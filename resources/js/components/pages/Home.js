import React, { Component } from "react";
import ReactDOM from "react-dom";
import Header from "../homepageComponents/Header";
import Slider from "../homepageComponents/Slider";
// import SearchProductContainer from "../homepageComponents/SearchProductContainer";
import SearchProductContainer from "../homepageComponents/SearchProductContainer";
import { StateProvider } from "../../Store/store";
import ProductDetailModal from "../homepageComponents/ProductDetailModal";

export default class Home extends Component {
    constructor() {
        super();
        this.state = {
            count: 0
        }
        // this is a comment

        this.doRerender = () => {
            this.setState({ count: this.state.count + 1 });
        };
    }

    render() {
        return (
            <StateProvider>
                <div>
                    <Header doRerender={this.doRerender} />
                    <Slider />
                    <SearchProductContainer />
                    <ProductDetailModal />
                </div>
            </StateProvider>
        );
    }
}

if (document.getElementById("app")) {
    ReactDOM.render(<Home />, document.getElementById("app"));
}
