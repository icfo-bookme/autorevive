import React from "react";

export default function ProductDetailModal(props) {
    return (
        <div
            className="modal fade"
            id="quickViewModal"
            tabIndex="-1"
            role="dialog"
            aria-labelledby="quickViewModalCenterTitle"
            aria-hidden="true"
        >
            <div className="modal-dialog modal-dialog-centered" role="document">
                <div className="modal-content">
                    <div
                        className="modal-header"
                        style={{ borderBottom: "none" }}
                    >
                        <button
                            type="button"
                            className="close__btn"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div className="modal-body">
                        <div className="row">
                            <div className="col-md-6">
                                <div className="modal_tab_img">
                                    <img id="xzoom-default" className="item_modal_image bigImage" src="" xoriginal="" />
                                </div>
                            </div>
                            <div className="col-md-6">
                                <h3 id="item_modal_name" className="mb-4">
                                    HEADER
                                </h3>
                                <p id="item_modal_detail">
                                    Lorem ipsum dolor sit amet.
                                </p>
                                {/* <div className="product_variant quantity">
                                    <button
                                        className="button"
                                        type="button"
                                        onClick={() =>
                                            addItemToCart(
                                                props.productDetail.id
                                            )
                                        }
                                    >
                                        add to cart
                                    </button>
                                </div> */}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
