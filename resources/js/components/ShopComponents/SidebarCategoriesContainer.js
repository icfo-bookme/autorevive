import React from "react";
import SidebarSubCategories from "./SidebarSubCategories";
export default function SidebarCategoriesContainer(props) {
    return (
        <li className="widget_sub_categories">
            <a
                onClick={() => props.getCategoriesData(props.categories.id)}
                className="active"
            >
                {props.categories.name}
            </a>

            <ul className="widget_dropdown_categories">
                {props.categories.sub_category.map(subcat => (
                    <SidebarSubCategories
                        getSubCategoriesData={props.getSubCategoriesData}
                        data={subcat}
                        key={subcat.id}
                    />
                ))}
            </ul>
        </li>
    );
}
