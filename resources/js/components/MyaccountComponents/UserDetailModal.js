import React, { Component } from "react";
import { BASE_URL } from "../config/Constants";

export default function UserDetailModal() {
    let [user, setUser] = React.useState({
        user: {},
        errors: {},
    });

    function changeUserDetails() {
        if (document.getElementById("logged").value != 0) {
            let user_details = {
                first_name: document.getElementById("first_name").value,
                last_name: document.getElementById("last_name").value,
                country: document.getElementById("country").value,
                city: document.getElementById("city").value,
                area: document.getElementById("area").value,
                house_no: document.getElementById("house_no").value,
                phone: document.getElementById("phone").value,
                email: document.getElementById("email").value,
                district: document.getElementById("district").value,
                thana: document.getElementById("thana").value,
                road_no: document.getElementById("road_no").value,
                flat_no: document.getElementById("flat_no").value,
                address: document.getElementById("address").value,
            };

            axios
                .post(`${BASE_URL}updateUsersInfoAjax`, {
                    ...user_details,
                    'csrf_token': document.head.querySelector('meta[name="csrf-token"]').content,
                })
                .then((data) => {
                    alertify.success("Information updated successfully!!");
                    $("#user_detail_modal").modal('hide');
                    $("#user_edit_modal_close").click();
                    // history.go(0);
                })
                .catch((err) => {
                    if (err.response.data.validationError) {
                        let errors_list = Object.keys(
                            err.response.data.validationError
                        );
                        errors_list.map((k) => {
                            alertify.error(
                                err.response.data.validationError[k]
                            );
                        });
                    } else {
                        alertify.error("An error occurred!");
                    }
                });
        }
    }


    return (
        <div
            className="modal fade bd-example-modal-lg"
            id="user_detail_modal"
            tabIndex="-1"
            role="dialog"
            aria-labelledby="myLargeModalLabel"
            aria-hidden="true"
        >
            <div className="modal-dialog modal-lg">
                <div className="modal-content" style={{ borderRadius: '5px' }}>
                    <button
                        type="button"
                        className="close__btn"
                        id="user_edit_modal_close"
                        data-dismiss="modal"
                        aria-label="Close"
                        style={{left: "97%"}}
                    >
                        <span aria-hidden="true">×</span>
                    </button>

                    <div className="card p-4">
                        <div className="card-body">
                            <div className="text-center">
                                <img
                                    src={
                                        BASE_URL +
                                        "mazley_assets/img/logo/automax-lg.png"
                                    }
                                    width={200}
                                    alt=""
                                />
                            </div>
                            <h6 className="line-on-side text-muted text-center text-xs-center font-small-3 pt-2">
                                <span>Update Account Information</span>
                            </h6>
                            

                            <form id="update_user_details_form">
                                <div className="row py-5">
                                    <div className="col-md-6">
                                        <div className="form-group">
                                            <label htmlFor="name">First Name</label>
                                            <div>
                                                <input
                                                    id="first_name"
                                                    type="text"
                                                    className="form-control"
                                                    name="first_name"
                                                    value={user.first_name}
                                                    required
                                                    autoComplete="first_name"
                                                    autoFocus
                                                />
                                               
                                            </div>
                                        </div>
                                        <div className="form-group">
                                            <label htmlFor="email">
                                                E-Mail Address
                                            </label>
                                            <div>
                                                <input
                                                    id="email"
                                                    type="email"
                                                    className="form-control"
                                                    name="email"
                                                    defaultValue={user.email}
                                                    required
                                                    autoComplete="email"
                                                    disabled
                                                />
                                                {user.errors.email ? (
                                                    <span
                                                        className="invalid-feedback"
                                                        role="alert"
                                                    >
                                                        <strong>
                                                            {user.errors.email}
                                                        </strong>
                                                    </span>
                                                ) : (
                                                    ""
                                                )}
                                            </div>
                                        </div>
                                        <div className="form-group">
                                            <label htmlFor="country">
                                                Country
                                            </label>
                                            <div>
                                                <select
                                                    className="form-control"
                                                    id="country"
                                                    name="country"
                                                    required
                                                    value={user.country}
                                                >
                                                    <option value="Bangladesh" >Bangladesh</option>
                                                    {/* <option value="USA">USA</option> */}
                                                </select>
                                            </div>
                                        </div>
                                        <div className="form-group">
                                            <label htmlFor="city">City</label>
                                            <div>
                                                <input
                                                    type="text"
                                                    id="city"
                                                    className="form-control"
                                                    name="city"
                                                    required
                                                    defaultValue={user.city}
                                                />
                                            </div>
                                        </div>
                                        <div className="form-group">
                                            <label htmlFor="area">Area</label>
                                            <div>
                                                <input
                                                    type="text"
                                                    id="area"
                                                    className="form-control"
                                                    name="area"
                                                    required
                                                    defaultValue={user.area}
                                                />
                                            </div>
                                        </div>
                                        <div className="form-group">
                                            <label htmlFor="house_no">
                                                House No
                                            </label>
                                            <div>
                                                <input
                                                    type="text"
                                                    id="house_no"
                                                    className="form-control"
                                                    name="house_no"
                                                    required
                                                    defaultValue={user.house_no}
                                                />
                                            </div>
                                        </div>
                                        <div className="form-group">
                                            <label htmlFor="phone">
                                                Contact Number
                                            </label>
                                            <div>
                                                <input
                                                    id="phone"
                                                    type="tel"
                                                    className="form-control"
                                                    name="phone"
                                                    required
                                                    defaultValue={user.phone}
                                                    // pattern="[0-9]{11}"
                                                    // placeholder={"01234123456"}
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-md-6">
                                    <div className="form-group">
                                            <label htmlFor="name">Last Name</label>
                                            <div>
                                                <input
                                                    id="last_name"
                                                    type="text"
                                                    className="form-control"
                                                    name="last_name"
                                                    value={user.last_name}
                                                    required
                                                    autoComplete="last_name"
                                                    autoFocus
                                                />
                                            </div>
                                        </div>

                                        <div className="form-group">
                                            <label htmlFor="district">
                                                District
                                            </label>
                                            <div>
                                                <input
                                                    type="text"
                                                    id="district"
                                                    className="form-control"
                                                    name="district"
                                                    required
                                                    defaultValue={user.district}
                                                />
                                            </div>
                                        </div>
                                        <div className="form-group">
                                            <label htmlFor="thana">Thana</label>
                                            <div>
                                                <input
                                                    type="text"
                                                    id="thana"
                                                    className="form-control"
                                                    name="thana"
                                                    required
                                                    defaultValue={user.thana}
                                                />
                                            </div>
                                        </div>
                                        <div className="form-group">
                                            <label htmlFor="road_no">
                                                Road no
                                            </label>
                                            <div>
                                                <input
                                                    type="text"
                                                    id="road_no"
                                                    className="form-control"
                                                    name="road_no"
                                                    required
                                                    defaultValue={user.road_no}
                                                />
                                            </div>
                                        </div>
                                        <div className="form-group">
                                            <label htmlFor="flat_no">
                                                Flat no
                                            </label>
                                            <div>
                                                <input
                                                    type="text"
                                                    id="flat_no"
                                                    className="form-control"
                                                    name="flat_no"
                                                    required
                                                    defaultValue={user.flat_no}
                                                />
                                            </div>
                                        </div>
                                        <div className="form-group">
                                            <label htmlFor="address">
                                                Address
                                            </label>
                                            <div>
                                                <textarea
                                                    id="address"
                                                    className="form-control"
                                                    name="address"
                                                    required
                                                    defaultValue={user.address}
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div className="text-center my-2">
                                    <button
                                        type="button"
                                        className="btn btn-primary"
                                        onClick={changeUserDetails}
                                    >
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
