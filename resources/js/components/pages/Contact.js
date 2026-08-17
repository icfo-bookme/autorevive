import React, { Component } from 'react';
import ReactDOM from "react-dom";
import Header from "../homepageComponents/Header";
import ContactContent from "../contactpageComponents/ContactContents";

class Contact extends Component {

    constructor() {
        super();
      
    }
    render() {
        return (
            <div>
               <Header />
               <ContactContent/> 
            </div>
        );
    }
}

if (document.getElementById("contactApp")) {
    ReactDOM.render(<Contact />, document.getElementById("contactApp"));
}
