import React from "react";
export default function SidebarSubCategories(props) {

    return (
        
            <li>
                <a onClick = {()=>props.getSubCategoriesData(props.data.id)} >{props.data.name}</a>
            </li>
       
    );
}
