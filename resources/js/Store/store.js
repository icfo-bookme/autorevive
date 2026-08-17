import React, { createContext, useReducer } from "react";

const initialState = {
	products: [],
	sections: [],
	companies: [],
    searchDropDowns: [],
    count: 0,
    sideCartData: [],
};

const store = createContext(initialState);
const { Provider } = store;

const StateProvider = ({ children }) => {
    const [state, dispatch] = useReducer((state, action) => {
        switch (action.type) {
            case "GET_NEW_SECTION":
                const newState = {
                    sections: action.payload.sections
                };
                return newState;
            case "SEARCH_PRODUCT":
                const searchedState = {
                    sections: action.payload.sections,
                    products: action.payload.latestProducts
                };
                return searchedState;
            case "GET_NEW_DATA": // same as SEARCH_PRODUCT, just different action name
                const newStateData = {
                    sections: action.payload.sections,
                    products: action.payload.latestProducts
                };
                return newStateData;
            default:
                throw new Error();
        }
    }, initialState);

    return <Provider value={{ state, dispatch }}>{children}</Provider>;
};

export { store, StateProvider };
