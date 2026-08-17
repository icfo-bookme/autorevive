import React, { useContext } from "react";
import CarFilter from "./CarFilter";
import ProductContainer from "./ProdcutContainer";
import { store } from "../../Store/store";

let products = undefined;
let sections = undefined;
let companies = undefined;
let myState = {
    products: [],
    sections: [],
    companies: [],
    count: 0
};


export default function SearchProductContainer() {
    const globalState = useContext(store);

    let getCompanies = () => {
        axios.post("getCompanies").then(({ data }) => {
            companies = data;
        });
    };

    let getLatestCollection = () => {
        axios.post("latestCollection").then(({ data }) => {
            myState.products = data;
        });
    };

    let getDynamicSections = () => {
        axios.post("dynamicSections").then(({ data }) => {
            myState.sections = data;
        });
    };

    getCompanies();
    getDynamicSections();
    getLatestCollection();

    let savedSections = globalState.state.sections;
    let savedPoducts = globalState.state.products;

    // let stateSectionsHasData =
    //     (! Object.keys(savedSections).length === 0) &&
    //     savedSections.constructor === Array;

    // let stateProductsHasData =
    //     (! Object.keys(savedPoducts).length === 0) &&
    //     savedPoducts.constructor === Array;

    let stateSectionsIsEmpty = savedSections.length > 0;
    let stateProductsIsEmpty = savedPoducts.length > 0;



    // if state's "sections" and "products" are empty or doesn't match with new data
    if (stateSectionsIsEmpty || stateProductsIsEmpty) {
        let isSectionsLoaded =
            JSON.stringify(globalState.state.sections) ==
                JSON.stringify(myState.sections) &&
            globalState.state.sections.length > 0;
        let isProductsLoaded =
            JSON.stringify(globalState.state.products) ==
                JSON.stringify(myState.products) &&
            globalState.state.products.length > 0;

        if (!(isSectionsLoaded && isProductsLoaded)) {
            let x = !(isSectionsLoaded && isProductsLoaded);
            globalState.dispatch({
                type: "GET_NEW_DATA",
                payload: {
                    sections: myState.sections,
                    products: myState.products
                }
            });
            console.log(globalState.state);
        }
    }
    else {
        console.log(
            "%c =====(One of State HAS data)=====",
            "background: #222; color: #bada55"
        );
    }

    return (
        <div>
            <CarFilter companies={ [companies] } />

            {/* globalState.state.sections.map... */}
            <ProductContainer
                products={myState.products}
                name="Latest Collection"
            />

            {/* globalState.state.sections.map... */}
            {myState.sections.map((val, k) => (
                <ProductContainer
                    products={val.items}
                    name={val.name}
                    key={k}
                />
            ))}
        </div>
    );
}
