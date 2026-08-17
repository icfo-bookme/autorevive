import React from "react";

function CategoriesAccordion(props) {
    return (
   
            <div className = "col-lg-3 col-sm-3 order-1">
            <div className="contenedor-menu shadow-sm">
                <ul className="menu">
                    <li>
                        <a href="#">Element 1</a>
                    </li>
                    <li>
                        <a href="#">
                            Element 2 <i className="fa fa-chevron-down"></i>
                        </a>
                        <ul>
                            <li>
                                <a href="#">Sub-Element #1Sub-Element #1</a>
                            </li>
                            <li>
                                <a href="#">Sub-Element #2</a>
                            </li>
                            <li>
                                <a href="#">Sub-Element #3</a>
                            </li>
                            <li>
                                <a href="#">Sub-Element #4</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Element 3</a>
                    </li>
                    <li>
                        <a href="#">
                            Element 4 <i className="fa fa-chevron-down"></i>
                        </a>
                        <ul>
                            <li>
                                <a href="#">Sub-Element #1</a>
                            </li>
                            <li>
                                <a href="#">Sub-Element #2</a>
                            </li>
                            <li>
                                <a href="#">Sub-Element #3</a>
                            </li>
                            <li>
                                <a href="#">Sub-Element #4</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Element 5</a>
                    </li>
                    <li>
                        <a href="#">Element 6</a>
                    </li>
                    <li>
                        <a href="#">
                            Element 7 <i className="fa fa-chevron-down"></i>
                        </a>
                        <ul>
                            <li>
                                <a href="#">Sub-Element #1</a>
                            </li>
                            <li>
                                <a href="#">Sub-Element #2</a>
                            </li>
                            <li>
                                <a href="#">Sub-Element #3</a>
                            </li>
                            <li>
                                <a href="#">Sub-Element #4</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Element 8</a>
                    </li>
                </ul>
            </div>
            </div>

    
    );
}

export default CategoriesAccordion;
