import React, { useContext, useState } from "react";
import { BASE_URL } from '../config/Constants';
import { store } from "../../Store/store";

let companies = [];
let brands = undefined;
let models = undefined;
let brandss = undefined;
let modelss = undefined;
let companiess = undefined;
let dropdowndData = {
    company_id: 0,
    brand_id: 0,
    model_id: 0
};

function useForceUpdate() {
    const [value, setValue] = useState(0); // integer state
    return () => setValue(value => ++value); // update the state to force render
}

/*
let getModels = () => {
    axios.post("getAllModelsAjax").then(({ data }) => {
        models = data.map(model => (
            <option
                value={model.id}
                key={model.id}
                data-company_id={model.company_id}
                data-brand_id={model.brand_id}
            >
                {model.car_model}
            </option>
        ));
    });
};

let getBrands = () => {
    axios.post("getAllBrandsAjax").then(({ data }) => {
        brands = data.map(brand => (
            <option
                value={brand.id}
                key={brand.id}
                data-company_id={brand.company_id}
            >
                {brand.car_brand}
            </option>
        ));
    });
};
*/

let getCompanies = () => {
    axios.post("getCompanies").then(res => {
        companies = res.data.map(category => (
            <option value={category.id} key={category.id}>
                {category.car_company}
            </option>
        ));
    });
};

let getCompaniesFromProps = (propsData) => {
    if (propsData != undefined) {
        let keyList = Object.keys(propsData);
        companies = [];

        keyList.forEach(i => {
            let company_i = propsData[i];
            companies.push(
                <option value={company_i.id} key={company_i.id}>
                    {company_i.car_company}
                </option>
            );
        });

        console.log(companies);
    }
}

let loadCompanies = () => {
    companies = res.data.map(category => (
        <option value={category.id} key={category.id}>
            {category.car_company}
        </option>
    ));
}

let getBrandByCompanyIdAjax = () => {
    axios
        .post("getBrandByCompanyIdAjax", { id: dropdowndData.company_id })
        .then(res => {
            brandss = res.data.map(brand => (
                <option
                    value={brand.id}
                    key={brand.id}
                    data-company_id={brand.company_id}
                >
                    {brand.car_brand}
                </option>
            ));
        });
};

let getModelByBrandIdAjax = () => {
    axios
        .post("getModelByBrandIdAjax", { id: dropdowndData.brand_id })
        .then(res => {
            modelss = res.data.map(model => (
                <option
                    value={model.id}
                    key={model.id}
                    data-company_id={model.company_id}
                    data-brand_id={model.brand_id}
                >
                    {model.car_model}
                </option>
            ));
        });
};

let setDropdownData = (company_id = 0, brand_id = 0, model_id = 0) => {
    dropdowndData.company_id = Number(company_id);
    dropdowndData.brand_id = Number(brand_id);
    dropdowndData.model_id = Number(model_id);

    console.log(dropdowndData);
};

let searchCar = () => {
    let requestProps = {
        companyId: dropdowndData.company_id,
        brandId: dropdowndData.brand_id,
        modelId: dropdowndData.model_id
    };

    axios.post("getProductsByProps", requestProps).then(res => {
    // axios.post("dynamicSections").then(res => {
        const globalState = useContext(store);
        if (globalState.state.sections != res.data.sections 
                || globalState.state.products != res.data.latestProducts) {
            globalState.dispatch({
                type: "SEARCH_PRODUCT",
                payload: {
                    sections: res.data.sections,
                    products: res.data.latestProducts
                }
            });
        }

        console.log(globalState);
    });
};

let _testGetData = () => {
    console.log("===(Init-State)===");
    let globalState = useContext(store);
    console.log(globalState);

    axios.post("dynamicSections").then(res => {
        globalState.dispatch({
            type: "GET_NEW_SECTION",
            payload: {
                sections: res.data
            }
        });
        console.log("===(Post-Load-State)===");
        console.log(globalState);
    });
}

export default function CarFilter(props) {
    console.log('====={CarFilter}=====');
    companiess = props.companies[0];
    // console.log(companiess);

    getCompaniesFromProps(companiess);
    // console.log(JSON.parse(x));
    // companies = props.companies;

    // getCompanies();
    // _testGetData();
    // ***********************************************
    // getting + setting store data
    // axios.post("dynamicSections").then(res => {
    //     console.log('===(Init-State)===');
    //     const globalState = useContext(store);
    //     globalState.dispatch({
    //         type: "GET_NEW_SECTION",
    //         payload: {
    //             sections: res.data
    //         }
    //     });
    //     console.log("===(Post-Load-State)===");
    //     console.log(globalState);
    // });
    // ***********************************************

    let forceUpdate = useForceUpdate();

    return (
        <section>
            <div className="shipping_area shipping_three mb-75">
                <div className="container">
                    <div className="row justify-content-center align-items-center">
                        <div className="col-sm-12 col-md-12 col-lg-10">
                            <div className="car-model-select p-5">
                                <div className="text-center">
                                    <h2 className="text-white">
                                        {" "}
                                        <img src="mazley_assets/img/car-select.png" />{" "}
                                        Select Your Car
                                    </h2>
                                </div>
                                <form id="carSearchForm">
                                    <div className="row">
                                        <div className="col-sm-2"></div>
                                        <div className="col-sm-2">
                                            <label className="text-white">
                                                Company
                                            </label>

                                            <select
                                                className="w-100 form-control"
                                                id="car_company"
                                                onChange={e => {
                                                    getBrandByCompanyIdAjax();
                                                    setDropdownData(
                                                        e.target.value,
                                                        0,
                                                        0
                                                    );
                                                    forceUpdate();
                                                }}
                                            >
                                                <option value="">
                                                    Select Company
                                                </option>
                                                {companies}
                                            </select>
                                        </div>
                                        <div className="col-sm-2">
                                            <label className="text-white">
                                                Brand
                                            </label>

                                            <select
                                                className="w-100 form-control"
                                                id="car_brand"
                                                onChange={e => {
                                                    let companyId = e.target.selectedOptions[0].getAttribute(
                                                        "data-company_id"
                                                    );
                                                    setDropdownData(
                                                        companyId,
                                                        e.target.value,
                                                        0
                                                    );
                                                    getModelByBrandIdAjax();
                                                    forceUpdate();
                                                }}
                                            >
                                                <option value="">
                                                    Select Brand
                                                </option>
                                                {brandss}
                                            </select>
                                        </div>
                                        <div className="col-sm-2">
                                            <label className="text-white">
                                                Model
                                            </label>

                                            <select
                                                className="w-100 form-control"
                                                id="car_model"
                                                onChange={e => {
                                                    let companyId = e.target.selectedOptions[0].getAttribute(
                                                        "data-company_id"
                                                    );
                                                    let brandId = e.target.selectedOptions[0].getAttribute(
                                                        "data-brand_id"
                                                    );
                                                    setDropdownData(
                                                        companyId,
                                                        brandId,
                                                        e.target.value
                                                    );
                                                }}
                                            >
                                                <option value="">
                                                    Select Model
                                                </option>
                                                {modelss}
                                            </select>
                                        </div>

                                        <div className="col-sm-2 d-flex">
                                            {/* <button type="button" id="searchCar" className="car-finder__button align-self-center"
                                                style={{ "marginTop": "20px"}} onClick={()=>props.handleChange()}>Search</button> */}

                                            <button
                                                type="button"
                                                id="searchCar"
                                                className="car-finder__button align-self-center"
                                                style={{ marginTop: "20px" }}
                                                // onClick={() => {
                                                //     getSectionData();
                                                // }}
                                                onClick={() => searchCar()}
                                            >
                                                Search
                                            </button>
                                        </div>
                                        <div className="col-sm-2"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}

function getSectionData() {
    axios.post("dynamicSections").then(res => {
        const globalState = useContext(store);
        console.log(globalState);
        const { dispatch } = globalState;
        dispatch({
            type: "GET_NEW_SECTION",
            payload: {
                sections: res.data
            }
        });
        console.log(globalState);
    });
}
