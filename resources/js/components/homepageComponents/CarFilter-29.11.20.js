import React, { useState } from "react";
import { BASE_URL } from "../config/Constants";

let companies = [];
let brandss = undefined;
let modelss = undefined;
let dropdowndData = {
    companyId: "",
    brandId: "",
    modelId: ""
};

let companiess = undefined;
let brands = undefined;
let models = undefined;

// let getCompaniesFromProps = (propsData) => {
//     if (propsData != undefined) {
//         let keyList = Object.keys(propsData);
//         companies = [];

//         keyList.forEach(i => {
//             let company_i = propsData[i];
//             companies.push(
//                 <option value={company_i.id} key={company_i.id}>
//                     {company_i.car_company}
//                 </option>
//             );
//         });

//         console.log(companies);
//     }
// }

let loadCompanies = companiesArr => {
    companies = companiesArr.map(company => (
        <option value={company.id} key={company.id}>
            {company.car_company}
        </option>
    ));
};

// let getBrandByCompanyIdAjax = (id) => {
//     axios
//         .post("getBrandByCompanyIdAjax", { id: id })
//         .then(res => {
//             brandss = res.data.map(brand => (
//                 <option
//                     value={brand.id}
//                     key={brand.id}
//                     data-company_id={brand.company_id}
//                 >
//                     {brand.car_brand}
//                 </option>
//             ));
//         });
// };

let getBrandByCompanyIdAjax = id => {
    axios.post(BASE_URL + "getBrandByCompanyIdAjax", { id: id }).then(res => {
        brands = "<option value=''>Select Brand</option>";
        res.data.forEach(brand => {
            brands += `<option
                value=${brand.id}
                key=${brand.id}
                data-company_id=${brand.company_id}
            >
                ${brand.car_brand}
            </option>`;
        });
        document.getElementById("car_brand").innerHTML = brands;
    });

    axios.post(BASE_URL + "getModelByBrandIdAjax",{ company_id: id }).then(res => {
        models = "<option value=''>Select Model</option>";
        res.data.forEach(
            model =>
                (models += `<option
                    value=${model.id}
                    key=${model.id}
                    data-company_id=${model.company_id}
                    data-brand_id=${model.brand_id}
                >
                    ${model.car_model}
                </option>`)
        );
        document.getElementById("car_model").innerHTML = models;
    });
};

let getModelByBrandIdAjax = id => {
    axios.post(BASE_URL + "getModelByBrandIdAjax", { id: id }).then(res => {
        models = "<option value=''>Select Model</option>";
        res.data.forEach(
            model =>
                (models += `<option
                    value=${model.id}
                    key=${model.id}
                    data-company_id=${model.company_id}
                    data-brand_id=${model.brand_id}
                >
                    ${model.car_model}
                </option>`)
        );
        document.getElementById("car_model").innerHTML = models;
    });
};

let setDropdownData = (company_id = 0, brand_id = 0, model_id = 0) => {
    dropdowndData.companyId = company_id == 0 ? "" : company_id;
    dropdowndData.brandId = brand_id == 0 ? "" : brand_id;
    dropdowndData.modelId = model_id == 0 ? "" : model_id;

    console.log(dropdowndData);
};

export default function CarFilter(props) {
    loadCompanies(props.companies);
    const [count, setCount] = useState(0);
    let forceUpdate = () => {
        setCount(count => ++count);
    };

    let tempData = {
        companyId: 1,
        brandId: 1,
        modelId: 3
    };
    // props.searchCar(tempData);

    return (
        <section>
            <div className="shipping_area shipping_three mb-75">
                <div className="container">
                    <div className="row justify-content-center align-items-center">
                        <div className="col-sm-12 col-md-12 col-lg-10">
                            <div className="car-model-select p-5">
                                <div className="text-center">
                                    <h2 className="text-white">
                                        <img
                                            src="mazley_assets/img/car-select.png"
                                            width="55"
                                            height="55"
                                            className="pr-3"
                                        />
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
                                                    getBrandByCompanyIdAjax(
                                                        e.target.value
                                                    );
                                                    setDropdownData(
                                                        e.target.value,
                                                        0,
                                                        0
                                                    );
                                                    forceUpdate();
                                                }}
                                            >
                                                <option value="">
                                                    Select Category
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
                                                    getModelByBrandIdAjax(
                                                        e.target.value
                                                    );
                                                    forceUpdate();
                                                }}
                                            >
                                                <option value="">
                                                    Select Brand
                                                </option>
                                                {/* {brandss} */}
                                                {brands}
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
                                            <button
                                                type="button"
                                                id="searchCar"
                                                className="car-finder__button align-self-center"
                                                style={{ marginTop: "20px" }}
                                                // onClick={() => {
                                                //     getSectionData();
                                                // }}
                                                onClick={() =>
                                                    props.searchCar(
                                                        dropdowndData
                                                    )
                                                }
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
    axios.post(BASE_URL + "dynamicSections").then(res => {
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
