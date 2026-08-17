import React, { Component } from 'react';
import ReactDOM from "react-dom";
import Header from "../homepageComponents/Header";
import AccountSettings from "../MyaccountComponents/AccountSettings"

class Account extends Component {
    render() {
        return (
            <div>
                <Header/>
                <AccountSettings />
            </div>
        );
    }
}
if (document.getElementById("accountApp")) {
    ReactDOM.render(<Account />, document.getElementById("accountApp"));
}
