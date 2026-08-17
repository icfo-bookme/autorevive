import React from 'react';
import { BASE_URL, CSRF_TOKEN } from "../config/Constants";

// password
// confirm_password

function setNewPassword() {
    let old_password = document.getElementById('old_password').value;
    let password = document.getElementById('modalPassword').value;
    let confirm_password = document.getElementById('confirm_password').value;

    // console.log("password", password);
    // console.log("confirm_password", confirm_password);
    if(old_password === ""){
        alertify.error("Enter Your Password");
    } else if(password.length < 8 && confirm_password.length < 8) {
        alertify.error("Password must be at least 8 characters long");
    } else {
        axios
        .post(BASE_URL + "setNewPassword", {
            old_password: document.getElementById("old_password").value,
            password: document.getElementById("modalPassword").value,
            password_confirmation: document.getElementById("confirm_password").value,
        })
        .then((response) => {

            if(response.data == "Success"){
                alertify.success("Success");
                setTimeout(() => location.reload(), 1000);
            } else {
                alertify.error("Please Enter Your Current Password Correctly!");
                $("#old_password").val("");
                $("#modalPassword").val("");
                $("#confirm_password").val("");
            }
            
        })
        .catch(err => {
            if (err.response.data.validationError) {
                console.error('Input error! ' + err.response.data.validationError);
                alertify.error('New Password Did Not Match!');
            }
        });
    }

}

export default function ChangePasswordModal() {
    return (
        <div
            className="modal fade"
            id="changePasswordModal"
            tabIndex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div className="modal-dialog" role="document">
                <div className="modal-content" style={{ borderRadius: '7px' }}>
                    <div className="modal-header">
                        <h5 className="modal-title" id="exampleModalLabel">
                            Change Password
                        </h5>
                        <button
                            type="button"
                            className="close__btn"
                            data-dismiss="modal"
                            aria-label="Close"
                            style={{ left: '95%' }}
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div className="modal-body">
                        <div className="form-group mb-3">
                            <label>Current Password</label>
                            <input
                                name="old_password"
                                type="password"
                                id="old_password"
                                placeholder="Enter old password"
                                className="form-control"
                            />
                        </div>
                        <div className="form-group mb-3">
                            <label>New Password</label>
                            <input
                                name="password"
                                type="password"
                                id="modalPassword"
                                placeholder="Enter new password"
                                className="form-control"
                            />
                        </div>
                        <div className="form-group my-3">
                            <label>Re-type New Password</label>
                            <input
                                name="confirm_password"
                                type="password"
                                id="confirm_password"
                                placeholder="Confirm password"
                                className="form-control"
                            />
                        </div>
                    </div>
                    <div className="modal-footer">
                        <button
                            type="button"
                            className="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                        <button
                            type="submit"
                            onClick={setNewPassword}
                            className="btn btn-primary"
                        >
                            Save changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
}
