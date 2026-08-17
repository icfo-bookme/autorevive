import React, { Component } from "react";
import {BASE_URL}  from "../config/Constants";

class ContactContents extends Component {
    constructor(){
        super();
        this.state = {
            fields: {},
            errors: {}
        };

        // this.onChangeHandler = this.onChangeHandler.bind(this);
        // this.onEmailHandler = this.onEmailHandler.bind(this);
        // this.onMobileNumber = this.onMobileNumber.bind(this);
        // this.sendMessage = this.sendMessage.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleInputChange = this.handleInputChange.bind(this);
        this.validateForm = this.validateForm.bind(this);
        //this.complainHandler = this.complainHandler.bind(this);
        //this.suggestionHandler = this.suggestionHandler.bind(this);
        
    }

    handleInputChange = (e) => {
        e.preventDefault();
        let fields = this.state.fields;
        fields[e.target.name] = e.target.value;
        this.setState({
            fields: fields
        });
     }

    // handleSubmit = (e) => {
    //       this.sendData(e);
    // }
    // complainHandler = (e) => {
    //     this.sendData(e);
    // }
    // suggestionHandler = (e) => {
    //     this.sendData(e);
    // }

    handleSubmit = (e) =>{
        e.preventDefault();
        if (this.validateForm()) {
            let fieldsObj = Object.assign(this.state.fields, {type: this.state.type});
            axios
              .post(BASE_URL + "contactMailSendAjax", fieldsObj)
              .then(response => {
                  alertify.success("Successfully Sent");
              });
  
           this.setState({
              fields: {
                  firstName: '',
                  email: '',
                  mobilenumber: '',
                  mssge: '',
                  type: ''
              },
              errors:{
                  firstName: '',
                  email: '',
                  mobilenumber: '',
                  mssge: '',
                  type: ''
              }
          })
        } 
    }

    validateForm() {

        let fields = this.state.fields;
        let errors = {};
        let formIsValid = true;
  
        if (!fields["firstName"]) {
          formIsValid = false;
          errors["firstName"] = "*Please enter your firstName.";
        }
  
        if (typeof fields["firstName"] !== "undefined") {
          if (!fields["firstName"].match(/^[a-zA-Z ]*$/)) {
            formIsValid = false;
            errors["firstName"] = "*Please enter alphabet characters only.";
          }
        }
  
        if (!fields["email"]) {
          formIsValid = false;
          errors["email"] = "*Please enter your email-ID.";
        }
  
        if (typeof fields["email"] !== "undefined") {
          //regular expression for email validation
          var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
          if (!pattern.test(fields["email"])) {
            formIsValid = false;
            errors["email"] = "*Please enter valid email-ID.";
          }
        }
  
        if (!fields["mobilenumber"]) {
          formIsValid = false;
          errors["mobilenumber"] = "*Please enter your mobile no.";
        }
  
        if (typeof fields["mobilenumber"] !== "undefined") {
          if (!fields["mobilenumber"].match(/^[0-9]{11}$/)) {
            formIsValid = false;
            errors["mobilenumber"] = "*Please enter valid mobile no.";
          }
        }
  
        if (!fields["mssge"]) {
          formIsValid = false;
          errors["mssge"] = "*Please enter your message.";
        }
  
        if (typeof fields["mssge"] !== "undefined") {
          if (!fields["mssge"].match(/^[a-zA-Z ]*$/)) {
            formIsValid = false;
            errors["mssge"] = "*Please enter secure and strong message.";
          }
        }
  
        this.setState({
          errors: errors
        });
        return formIsValid;
  
  
      }
    render() {
        return (
            <div>
                <div className="contact_page_bg">
                    <div className="container">
                        <div className="contact_area">
                        <h2 className="section__title">Contact Us</h2>
                            <div className="row py-5">
                                <div className="col-lg-6 col-md-12">
                                    <div className="contact_message content">
                                        <h3>Address Information</h3>

                                        <ul>
                                            <li>
                                                <i className="fa fa-fax"></i>{" "}
                                                Address: 315, Dewan Chamber,{" "}
                                                <br />
                                                Sheikh Mujib Rd, Dewanhut,
                                                <br/>
                                                Chattogram
                                            </li>
                                            <li>
                                                <a href="tel: 01888022244"> <i className="fa fa-phone"></i> 01888022244</a>
                                            </li>
                                            <li>
                                                <i className="fa fa-envelope-o"></i>{" "}
                                                info@automart.com.bd
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div className="col-lg-6 col-md-12">
                                    <div className="contact_message form">
                                    
                                        <div className="clearfix"></div>
                                        <nav>
                                            <div className="nav nav-tabs" id="nav-tab" role="tablist">
                                                <a className="nav-item nav-link active border-none" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Have a question?
                                                </a>
                                                <a className="nav-item nav-link border-none" id="nav-second-tab" data-toggle="tab" href="#nav-second" role="tab" aria-controls="nav-second" aria-selected="false">Make a complaint?</a>
                                                <a className="nav-item nav-link border-none" id="nav-third-tab" data-toggle="tab" href="#nav-third" role="tab" aria-controls="nav-third" aria-selected="false">Any suggestion?</a>
                                            </div>
                                        </nav>
                                        <div className="tab-content px-2 py-2" id="nav-tabContent">
                                            <div className="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                                <div className="row">
                                                  <div className="col-sm-12">
                                                  <form onSubmit= {this.handleSubmit} id="question_form">
                                                        <div>
                                                            <label>Name</label>
                                                                <input type="text" name="firstName" value={this.state.fields.firstName} onChange ={this.handleInputChange} placeholder="name" />
                                                                 <p className="text-danger">{this.state.errors.firstName}</p>
                                                        </div>
                                                        <div>
                                                            <label>Email</label>
                                                            
                                                            <input type="email" name="email" value={this.state.fields.email}onChange ={this.handleInputChange} placeholder="email" />
                                                            <p className="text-danger">{this.state.errors.email}</p>
                                                        </div>
                                                        <div>
                                                            <label>Number</label>
                                                            
                                                            <input type="text" name="mobilenumber" value={this.state.fields.mobilenumber}onChange={this.handleInputChange} placeholder="mobile number"/>
                                                            <p className="text-danger">{this.state.errors.mobilenumber}</p>
                                                        </div>
                                                        <div className="contact_textarea">
                                                            <label>Query Box</label>
                                                            
                                                                <textarea name="mssge" value={this.state.fields.mssge} onChange = {this.handleInputChange} className="form-control2"></textarea>
                                                               <p className="text-danger">{this.state.errors.mssge}</p>
                                                        </div>
                                                            <button
                                                                type="submit"
                                                                className="btn btn-primary"
                                                                onClick={() => this.setState({
                                                                    type: 'Question'
                                                                })}
                                                            >
                                                                {" "}
                                                                Send Message
                                                            </button>
                                                        <p className="form-messege"></p>
                                                        </form>
                                                  </div>
                                                </div>
                                            </div>
                                            <div className="tab-pane fade" id="nav-second" role="tabpanel" aria-labelledby="nav-second-tab">
                                            <div className="row">
                                                  <div className="col-sm-12">
                                                    <form onSubmit= {this.handleSubmit} id="complain_form">
                                                        <div>
                                                            <label>Name</label>
                                                                <input type="text" name="firstName" value={this.state.fields.firstName} onChange ={this.handleInputChange} placeholder="name" />
                                                                 <p className="text-danger">{this.state.errors.firstName}</p>
                                                        </div>
                                                        <div>
                                                            <label>Email</label>
                                                            
                                                            <input type="email" name="email" value={this.state.fields.email}onChange ={this.handleInputChange} placeholder="email" />
                                                            <p className="text-danger">{this.state.errors.email}</p>
                                                        </div>
                                                        <div>
                                                            <label>Number</label>
                                                            
                                                            <input type="text" name="mobilenumber" value={this.state.fields.mobilenumber}onChange={this.handleInputChange} placeholder="mobile number"/>
                                                            <p className="text-danger">{this.state.errors.mobilenumber}</p>
                                                        </div>
                                                        <div className="contact_textarea">
                                                            <label>Complaint Box</label>
                                                            
                                                                <textarea name="mssge" value={this.state.fields.mssge} onChange = {this.handleInputChange} className="form-control2"></textarea>
                                                               <p className="text-danger">{this.state.errors.mssge}</p>
                                                        </div>
                                                            <button
                                                                type="submit"
                                                                className="btn btn-primary"
                                                                onClick={() => this.setState({
                                                                    type: 'Complain'
                                                                })}
                                                            >
                                                                {" "}
                                                                Send Message
                                                            </button>
                                                        <p className="form-messege"></p>
                                                        </form>
                                                  </div>
                                                </div>
                                            </div>
                                            <div className="tab-pane fade" id="nav-third" role="tabpanel" aria-labelledby="nav-third-tab">
                                            <div className="row">
                                                  <div className="col-sm-12">
                                                  <form onSubmit= {this.handleSubmit} id="suggestion_form">
                                                        <div>
                                                            <label>Name</label>
                                                                <input type="text" name="firstName" value={this.state.fields.firstName} onChange ={this.handleInputChange} placeholder="name" />
                                                                 <p className="text-danger">{this.state.errors.firstName}</p>
                                                        </div>
                                                        <div>
                                                            <label>Email</label>
                                                            
                                                            <input type="email" name="email" value={this.state.fields.email}onChange ={this.handleInputChange} placeholder="email" />
                                                            <p className="text-danger">{this.state.errors.email}</p>
                                                        </div>
                                                        <div>
                                                            <label>Number</label>
                                                            
                                                            <input type="text" name="mobilenumber" value={this.state.fields.mobilenumber}onChange={this.handleInputChange} placeholder="mobile number"/>
                                                            <p className="text-danger">{this.state.errors.mobilenumber}</p>
                                                        </div>
                                                        <div className="contact_textarea">
                                                            <label>Suggestion Box</label>
                                                            
                                                                <textarea name="mssge" value={this.state.fields.mssge} onChange = {this.handleInputChange} className="form-control2"></textarea>
                                                               <p className="text-danger">{this.state.errors.mssge}</p>
                                                        </div>
                                                            <button
                                                                type="submit"
                                                                className="btn btn-primary"
                                                                onClick={() => this.setState({
                                                                    type: 'Suggestion'
                                                                })}
                                                            >
                                                                {" "}
                                                                Send Message
                                                            </button>
                                                        <p className="form-messege"></p>
                                                        </form>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default ContactContents;
