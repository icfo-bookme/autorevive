import React, { useState } from "react";
import { BASE_URL } from '../config/Constants';

function uuidv4() {
    return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, (c) =>
        (
            c ^
            (crypto.getRandomValues(new Uint8Array(1))[0] & (15 >> (c / 4)))
        ).toString(16)
    );
}

function MainnavCategories(props) {
    const [state, setState] = useState({ categories: {} });
    const[showSubCategory, setShowSubCategory] = useState(false);
    const [getCaretId, setCaretId] = useState('')
    let categoriesJsx = [];
    let iKey = 0;

    if (Object.keys(state.categories).length == 0) {
        axios.post(BASE_URL + 'mainCategories').then(({ data }) => {
            if (JSON.stringify(state.categories) != JSON.stringify(data)) {
                setState({ categories: data });
            }
        });
    }
    const subCategoryShowHandler = (id) => {
        // console.log('I am open for id = ' + id)
        setShowSubCategory(!showSubCategory);
        setCaretId(id);
    }

    Object.keys(state.categories).map((count) => {
        let category = state.categories[count];
        let newKey = uuidv4();
        if (Object.keys(category.sub_category).length > 0) {
            categoriesJsx.push(
                <li className="list_item" key={category.id}>
                <span className="catgory_link d-flex  justify-content-between align-items-center">
                    <a target="_blank" 
                    href={BASE_URL + "shopByCategory/" + category.id} 
                    style={{ color: '#555', display: 'inline-block' }}> {category.name} </a>
                    <span className="fa fa-caret-down pr-3" 
                    onClick={()=> subCategoryShowHandler(category.id)} style={{ cursor: 'pointer' }}></span>
                </span>
                {
                    showSubCategory == true && getCaretId == category.id ? ( 
                    <ul className="sub_category_list_item" id={category.id}>
                        {category.sub_category.map(subCategory => {
                            return (
                                <li className="sub_category" key={subCategory.id}>
                                    <a target="_blank" href={BASE_URL + "shopBySubCategory/" + subCategory.id}>{subCategory.name} </a>
                                </li>
                            )
                        }
                        )}
                    </ul>
                    ) :''
                }
                </li>
                     

            );
        } else {
            categoriesJsx.push(
                <li className="list_item" key={category.id}>
                    <a className="catgory_link" href={BASE_URL + "shopByCategory/" + category.id} >{category.name}</a></li>

            );
        }
    });

    return (
        <ul>
            {categoriesJsx}
        </ul>
    );
}

export default React.memo(MainnavCategories);
