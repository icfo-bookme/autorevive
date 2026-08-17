import React, { useState, useEffect } from "react";
import { BASE_URL } from "../config/Constants";

let companies = [];
let modelss = undefined;
let brands = undefined;
let models = undefined;
let dropdowndData = {
    companyId: "",
    brandId: "",
    modelId: ""
};

let loadCompanies = companiesArr => {
    companies = companiesArr.map(company => (
        <option value={company.id} key={company.id}>
            {company.car_company}
        </option>
    ));
};

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

    // axios.post(BASE_URL + "getModelByBrandIdAjax",{ company_id: id }).then(res => {
    //     models = "<option value=''>Select Model</option>";
    //     res.data.forEach(
    //         model =>
    //             (models += `<option
    //                 value=${model.id}
    //                 key=${model.id}
    //                 data-company_id=${model.company_id}
    //                 data-brand_id=${model.brand_id}
    //             >
    //                 ${model.car_model}
    //             </option>`)
    //     );
    //     document.getElementById("car_model").innerHTML = models;
    // });
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

let setDropdownData = (setCarFilterParams = null) => {
    let company_id = document.getElementById("car_company").value;
    let brand_id = document.getElementById("car_brand").value;
    let model_id = document.getElementById("car_model").value;

    if(company_id !== dropdowndData.companyId){
        dropdowndData.companyId = company_id;
        dropdowndData.brandId = "";
        dropdowndData.modelId = "";
    }else{
        dropdowndData.companyId = company_id == 0 ? "" : company_id;
        dropdowndData.brandId = brand_id == 0 ? "" : brand_id;
        dropdowndData.modelId = model_id == 0 ? "" : model_id;
    }
    if (setCarFilterParams) {
        setCarFilterParams(dropdowndData);
    }
};
let redirectHandler = () => {
    let company_id = dropdowndData.companyId;
    let brand_id   = dropdowndData.brandId;
    let model_id   = dropdowndData.modelId;
    let slug       = "";
    location.href  = `${BASE_URL}shopview?comId=${company_id}&brandId=${brand_id}&modelId=${model_id}&slug=${slug}`;
}

export default function CarFilter(props) {
    loadCompanies(props.companies);
    const [count, setCount] = useState(0);
    const [pageUrl, setPageUrl] = useState(true);
    let forceUpdate = () => {
        setCount(count => ++count);
    };
    useEffect(() => {
        let pagePath = window.location.href.split("/")[3];
        let locatePath = location.search.split("&");
        if(pagePath == "" && locatePath.length !== 4){
            setPageUrl(false);
        }else{
            setPageUrl(true);
        }    
    }, [])
    let tempData = {
        companyId: 1,
        brandId: 1,
        modelId: 3
    };

    

    return (
        <section>
            <div className="shipping_area shipping_three mb-75">
                <div className="container">
                    <div className="row justify-content-center align-items-center">
                        <div className="col-10 col-sm-12 col-md-12 col-lg-12">
                            <div className="car-model-select p-5 car_filter_sm">
                                <div className="text-center">
                                    <h2 className="text-white mobile__font">
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
                                        {/* <div className="col-lg-2 col-sm-12 col-md-12"></div> */}
                                        <div className="col-lg-3 col-sm-12 col-md-12">
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
                                                    // setDropdownData
                                                    if (props.setCarFilterParams) {
                                                        setDropdownData(props.setCarFilterParams);
                                                    } else {
                                                        setDropdownData();
                                                    }
                                                    forceUpdate();
                                                }}
                                            >
                                                 <option value="">
                                                    Select
                                                </option>
                                                {companies}
                                            </select>
                                        </div>
                                        <div className="col-lg-3 col-sm-12 col-md-12">
                                            <label className="text-white">
                                                Brand
                                            </label>

                                            <select
                                                className="w-100 form-control"
                                                id="car_brand"
                                                onChange={e => {
                                                    // setDropdownData();
                                                    if (props.setCarFilterParams) {
                                                        setDropdownData(props.setCarFilterParams);
                                                    } else {
                                                        setDropdownData();
                                                    }
                                                    getModelByBrandIdAjax(
                                                        e.target.value
                                                    );
                                                    forceUpdate();
                                                }}
                                            >
                                                <option value="">
                                                    Select
                                                </option>
                                                {brands}
                                            </select>
                                        </div>
                                        <div className="col-lg-3 col-sm-12 col-md-12">
                                            <label className="text-white">
                                                Model
                                            </label>

                                            <select
                                                className="w-100 form-control"
                                                id="car_model"
                                                onChange={() => {
                                                    // setDropdownData()
                                                    if (props.setCarFilterParams) {
                                                        setDropdownData(props.setCarFilterParams);
                                                    } else {
                                                        setDropdownData();
                                                    }
                                                }}
                                            >
                                                <option value="">
                                                    Select
                                                </option>
                                                {modelss}
                                            </select>
                                        </div>

                                        <div className="col-lg-3 col-sm-12 col-md-12 d-flex">
                                            {pageUrl ? (<button
                                                type="button"
                                                id="searchCar"
                                                className="car-finder__button align-self-center"
                                                style={{ marginTop: "20px" }}
                                                onClick={() =>{
                                                    props.searchCar(dropdowndData);
                                                    document.getElementById("car_company").value = "";
                                                    document.getElementById("car_brand").value = "";
                                                    document.getElementById("car_model").value = "";
                                                    document.getElementById("car_brand").innerHTML = "<option value=''>Select</option>";
                                                    document.getElementById("car_model").innerHTML = "<option value=''>Select</option>";
                                                    setTimeout( function (){
                                                        dropdowndData.companyId = "";
                                                        dropdowndData.brandId   = "";
                                                        dropdowndData.modelId   = "";
                                                    }, 1200)

                                                }  
                                                }
                                            >
                                                Search
                                            </button>): (<button
                                                type="button"
                                                id="searchCarTwo"
                                                className="car-finder__button align-self-center"
                                                style={{ marginTop: "20px" }}
                                                onClick={() =>{
                                                    redirectHandler();
                                                }  
                                                }
                                            >
                                                Search
                                            </button>)}
                                            
                                        </div>
                                        {/* <div className="col-lg-2 col-sm-12 col-md-12"></div> */}
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
