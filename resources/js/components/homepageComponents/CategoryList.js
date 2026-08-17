import React from "react";
import CategoryItem from "./CategoryItem";
import select_option from "../../../../public/css/select_option.css";
import { BASE_URL } from "../config/Constants";


export default function CategoryList(props) {
    let search_params = location.search.substring(1).split("&");
    let selected_category = "";
    search_params.map(param => {
        if (param.split("=")[0] == 'catId') {
            selected_category = param.split("=")[1];
        }
    });
    
    return (
        <select
            className="himelSelect"
            name="select"
            id="select_category"
            onChange={(e) => props.handleCategorySelect(e)}
        >
            <option value="">Category</option>
            {props.categoryList.map((param1) => (
                <CategoryItem
                    id={param1.id}
                    value={param1.name}
                    key={param1.id}
                    selectedItem={selected_category}
                />
            ))}
        </select>
    );
}
