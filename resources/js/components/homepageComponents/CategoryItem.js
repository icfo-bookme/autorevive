import React, { Component } from "react";

export default function CategoryList(props) {
    return props.selectedItem == props.id ? (
        <option value={props.id} key={props.id} selected>
            {props.value}
        </option>
    ) : (
        <option value={props.id} key={props.id}>
            {props.value}
        </option>
    );
}
