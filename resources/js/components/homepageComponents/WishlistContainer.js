import React from "react";
import { BASE_URL } from '../config/Constants';



export default function CartContainer(props) {
    let wishData = props.data.wish;

    let items = [];
    if (wishData != undefined) {
        let objectKeys = Object.keys(wishData.items);

       

        objectKeys.forEach(element => {
            items.push(wishData.items[element].item);
        });
    } else {
     
    }
    return (
        <div className="header_wishlist">
            <a href={BASE_URL+'wishList'}><i className="icon-heart"></i>

                <span className="wishlist_count">{wishData?wishData.totalQty : 0}</span>
            </a>
        </div>
    );
}
