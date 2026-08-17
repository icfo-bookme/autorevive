import React, { Component } from "react";
import { BASE_URL } from "../config/Constants";

class AccountSettings extends Component {
    constructor() {
        super();
        this.state = {
            orderList: []
        };

        let token = document.head.querySelector('meta[name="csrf-token"]')
            .content;

        this.orderDetails = [];
    }

    componentDidMount() {

        axios
            .post(BASE_URL + "getMyAccountDetail", {
                id: Number(document.getElementById("logged").value)
            })
            .then(({ data }) => {
                console.log("account Details", data);
                this.setState({ orderList: data });

                let count = 0;
                this.state.orderList.forEach(order => {
                    this.orderDetails += `
                            <tr>
                                <td>${++count}</td>
                                <td>${order.created_at}</td>
                                <td>
                                    ${order.first_name} ${order.last_name}
                                </td>
                                <td>${order.order_sum_count}</td>
                                <td>`;

                                    if((order.is_approve == 0) && (order.is_rejected == 0) && (order.status == 0) && (order.shipment_assigned == 0) && (order.is_shipment == 0) && (order.is_payment == 0)) {
                                        this.orderDetails += `<button class="badge badge-info">Pending </button>`
                                    } 
                                    else if((order.is_approve == 0) && (order.is_rejected == 1) && (order.status == 0) && (order.shipment_assigned == 0) && (order.is_shipment == 0) && (order.is_payment == 0)) {
                                        this.orderDetails += `<button class="badge badge-danger">Cancelled</button>`;
                                    }
                                     else if ((order.is_approve == 1) && (order.is_rejected == 0) && (order.status == 0) && (order.shipment_assigned == 0) && (order.is_shipment == 0) && (order.is_payment == 0)) {
                                        this.orderDetails += `<button class="badge badge-warning">Approved</button>`
                                    } else if((order.is_approve == 1) && (order.is_rejected == 0) && (order.status == 0) && (order.shipment_assigned == 1) && (order.is_shipment == 0) && (order.is_payment == 0)) {
                                        this.orderDetails += `<button class="badge assigned-badge">Assigned for Shipment</button>`;
                                    } else if((order.is_approve == 1) && (order.is_rejected == 0) && (order.status == 0) && (order.shipment_assigned == 1) && (order.is_shipment == 1) && (order.is_payment == 0)) {
                                        this.orderDetails += `<button class="badge assigned-badge">Shipped</button>`;
                                    } else if((order.is_approve == 1) && (order.is_rejected == 0) &&(order.status == 1) && (order.shipment_assigned == 1) &&(order.is_shipment == 1) && (order.is_payment == 1) && (order.delivery_type == "delivery")) {
                                        this.orderDetails += `<button class="badge badge-success">Delivered</button>`;
                                    } else if((order.is_approve == 1) && (order.is_rejected == 0) &&(order.status == 1) && (order.shipment_assigned == 1) &&(order.is_shipment == 1) && (order.is_payment == 1) && (order.delivery_type == "pickup")) {
                                        this.orderDetails += `<button class="badge badge-success">Received</button>`;
                                    } else if((order.delivery_type == "shop") && (order.is_rejected == 0)) {
                                        this.orderDetails += `<button class="badge badge-success">Completed</button>`;
                                    } else if((order.delivery_type == "shop") && (order.is_rejected == 1)) {
                                        this.orderDetails += `<button class="badge badge-danger">Returned</button>`;
                                    }

                    this.orderDetails += `
                                </td>
                                <td>
                                    <button class="btn badge badge-secondary" onclick='productDetails(${order.id})' style="cursor: pointer">Details</button>
                                    <button type="button" onClick="getInvoiceDetails(${order.id})" class="btn badge badge-info" data-toggle="modal" data-target="#invoiceModal" style="cursor: pointer;color: white;">Invoice</button>
                                    `

                    // if((order.is_approve == 0) && (order.is_rejected == 0) && (order.status == 0) && (order.shipment_assigned == 0) && (order.is_shipment == 0) && (order.is_payment == 0)) {
                    //     this.orderDetails += `
                    //                 <button class="btn btn badge badge-danger" onclick='cancelOrder(${order.id})' style="cursor: pointer">Cancel Order</button>`
                    // }

                    this.orderDetails += `
                                </td>
                            </tr>`;
                }
                );
                document.getElementById("resBody").innerHTML = this.orderDetails;
            });
    }

    render() {
        let username = document.getElementById("logged_user_name").value;

        return (
            <div>
                <div className="container">
                    <div className="row py-5">
                        <div className="col-lg-12">
                            <div className="card">
                                <div className="card-header">
                                    <h4 className="card-title text-center mb-0">
                                        <i
                                            aria-hidden="true"
                                            className="fa fa-shopping-bag"
                                        ></i>
                                        {
                                        username 
                                        ?   ` Order Information of ${username}`
                                        :   ' Order Information'
                                        }
                                        
                                    </h4>
                                </div>
                                <div className="card-body py-5">
                                    <div className="row ">
                                        <div className="col-lg-7">
                                            <div className="table-responsive">
                                                <table className="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th> Sr. No. </th>
                                                            <th>Date</th>
                                                            <th>Customer</th>
                                                            <th>
                                                                Total Product
                                                            </th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="resBody"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div className="col-lg-5">
                                            <div className="table-responsive">
                                                <table
                                                    id="productDetails"
                                                    className="table table-bordered"
                                                >
                                                    <thead
                                                        className="text-white"
                                                        style={{
                                                            background:
                                                                "#1b2463",
                                                        }}
                                                    ></thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default AccountSettings;
