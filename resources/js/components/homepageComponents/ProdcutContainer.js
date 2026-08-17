// import React, { Component } from "react";
// import ProductInfo from "./ProductInfo";
// import "owl.carousel/dist/assets/owl.carousel.css";
// import "owl.carousel/dist/assets/owl.theme.default.css";
// import "../../../../public/mazley_assets/css/owncustom-carousel.css";
// import OwlCarousel, { Options } from "react-owl-carousel";
// import { BASE_URL } from "../config/Constants";
// // import ProductDetailModal from "./ProductDetailModal";

// export default class ProductContainer extends Component {
//     constructor(props) {
//         super(props);
//         this.state = {
//             options: {
//                 slideBy: 3,
//                 autoplay: false,
//                 autoplayHoverPause: true,
//                 autoplayTimeout: 3000,
//                 loop: true,
//                 dots: false,
//                 margin: 10,
//                 startPosition: 0,
//                 nav: false,
//                 // navText: [
//                 //     "<i class='fa fa-chevron-left owl-prev'></i>",
//                 //     "<i class='fa fa-chevron-right owl-next'></i>"
//                 // ],
//                 responsive: {
//                     0: {
//                         items: 1
//                     },
//                     320: {
//                         items: 3
//                     },
//                     360: {
//                         items: 3
//                     },
//                     375: {
//                         items: 3
//                     },
//                     411: {
//                         items: 3
//                     },
//                     414: {
//                         items: 3
//                     },
//                     480: {
//                         items: 3
//                     },
//                     576: {
//                         items: 3
//                     },
//                     600: {
//                         items: 3
//                     },
//                     1000: {
//                         items: 5
//                     }
//                 }
//             },
//             products: this.props.products,
//             skip: 0
//         };
//         this.nextItems = this.nextItems.bind(this);
//         this.previous = this.previous.bind(this);
//     }

//     nextItems = ()=>{
//         // this.props.setStateOfParent(8);
//         this.slider.next();
//         const sendGetRequest = async () => {
//             console.log("skip", this.state.skip);
//             let skipCount = this.state.skip + 8;
//             try {
//                 const resp = await axios.post(BASE_URL + "dynamicSections");
//                 this.setState({
//                     skip: skipCount
//                 })
//                 console.log("hellow", resp.data,);

//             } catch (err) {
//                 // Handle Error Here
//                 console.error(err);
//             }

//         };

//         sendGetRequest();
//     }
//     previous = () => {
//         this.slider.prev();
//     }
//     // componentDidMount() {
//     //     console.log("hellow I am here!!")
//     // }
//     render() {
//         let data = this.props.products.map((val, k) => {
//             return <ProductInfo product={val}  key={k} />;
//         });

//         return (
//             <div className="product_area product_style3 color_three">
//                 <div className="container mble_responsive">
//                     <div className="row mble_responsive">
//                         <div className="col-12">
//                             <div className="section_title title_style2">
//                                 <div className="title_content">
//                                     <h2>{this.props.name}</h2>
//                                 </div>
//                                 <div className="product_tab_btn">
//                                     <ul
//                                         className="nav"
//                                         role="tablist"
//                                     >
//                                         <li>
//                                             <a
//                                                 className="active"
//                                                 data-toggle="tab"
//                                                 href="#Sellers"
//                                                 role="tab"
//                                                 aria-controls="Sellers"
//                                                 aria-selected="true"
//                                             >
//                                                 {this.props.name}
//                                             </a>
//                                         </li>
//                                     </ul>
//                                 </div>
//                                 <div className="seeAll">
//                                            <a href={BASE_URL + "shopBySection/" + this.props.getId} className="button secondary__bg px-2" style={{ height: '25px', lineHeight: 2 }}>See All <i className="fa fa-long-arrow-right" aria-hidden="true"></i></a>
//                                            <button className="button mx-1 arrow__button" onClick={this.previous} style={{ height: '25px', lineHeight: 0,}}>
//                                                <i className="fa fa-chevron-left" aria-hidden="true"></i>
//                                            </button>
//                                            <button className="button mx-1 arrow__button" onClick={this.nextItems} style={{ height: '25px', lineHeight: 0,}}>
//                                                <i className="fa fa-chevron-right" aria-hidden="true"></i>
//                                            </button>
//                                     {/* <a href={BASE_URL + "shopBySection/" + this.props.getId} className="px-2">See All <i className="fa fa-long-arrow-right" aria-hidden="true"></i></a> */}
//                                 </div>
//                             </div>
//                         </div>
//                     </div>

//                     <div className="tab-content">
//                         <div
//                             className="tab-pane fade show active"
//                             id="Sellers"
//                             role="tabpanel"
//                         >
//                             <div className="product_area">
//                                 <div className="container mble_responsive">
//                                     <div className="row mble_responsive">
//                                         <div className="col-12 mble_responsive">
//                                             <div className="owl-slider">
//                                                 <OwlCarousel
//                                                 ref={slider => (this.slider = slider)}
//                                                     className="owl-theme"
//                                                     // loop
//                                                     {...this
//                                                         .state
//                                                         .options}
//                                                     margin={10}
//                                                     items={6}
//                                                     nav
//                                                 >
//                                                     {data}
//                                                 </OwlCarousel>
//                                             </div>
//                                         </div>
//                                     </div>
//                                 </div>
//                             </div>
//                         </div>
//                     </div>
//                 </div>
//             </div>
//         );
//     }
// }


import React, { useState, Component } from "react";
import ReactDOM from "react-dom";
import Carousel from "react-elastic-carousel";
import { BASE_URL } from "../config/Constants";
import ProductInfo from "./ProductInfo";
import "../../../../node_modules/slick-carousel/slick/slick.css"
import "../../../../node_modules/slick-carousel/slick/slick-theme.css";
import Slider from "react-slick";
import ProductDetailModal from "./ProductDetailModal";

// // const breakPoints = [
// //   { width: 1, itemsToShow: 1 },
// //   { width: 550, itemsToShow: 2, itemsToScroll: 2 },
// //   { width: 768, itemsToShow: 3 },
// //   { width: 991, itemsToShow: 5 }
// // ];

// // export default function ProductContainer (props) {
// //   let data = props.products.map((val, k) => {
// //         return <ProductInfo product={val}  key={k} />;
// //   });

// //   return (
// //     <div className="product_area product_style3 color_three">
// //                  <div className="container mble_responsive">
// //                      <div className="row mble_responsive">
// //                          <div className="col-12">
// //                              <div className="section_title title_style2">
// //                                  <div className="title_content">
// //                                      <h2>{props.name}</h2>
// //                                  </div>
// //                                  <div className="product_tab_btn">
// //                                      <ul
// //                                          className="nav"
// //                                          role="tablist"
// //                                      >
// //                                          <li>
// //                                              <a
// //                                                  className="active"
// //                                                  data-toggle="tab"
// //                                                  href="#Sellers"
// //                                                  role="tab"
// //                                                  aria-controls="Sellers"
// //                                                  aria-selected="true"
// //                                              >
// //                                                  {props.name}
// //                                              </a>
// //                                          </li>
// //                                      </ul>
// //                                  </div>
// //                                  <div className="seeAll">
// //                                      <a href={BASE_URL + "shopBySection/" + props.getId} className="px-2">See All <i className="fa fa-long-arrow-right" aria-hidden="true"></i></a>
// //                                  </div>
// //                              </div>
// //                          </div>
// //                      </div>

// //                      <div className="tab-content">
// //                          <div
// //                              className="tab-pane fade show active"
// //                              id="Sellers"
// //                              role="tabpanel"
// //                          >
// //                              <div className="product_area">
// //                                  <div className="container mble_responsive">
// //                                      <div className="row mble_responsive">
// //                                          <div className="col-12 mble_responsive">
// //                                              <div className="carousel-wrapper">
// //                                                 <Carousel
// //                                                     enableAutoPlay
// //                                                     autoPlaySpeed={2800}
// //                                                     itemPadding={[10, 10]}
// //                                                     outerSpacing ={4}
// //                                                     breakPoints={breakPoints}
// //                                                     onNextEnd={({ index }) => {
// //                                                         clearTimeout(resetTimeout)
// //                                                         if (index + 1 === totalPages) {
// //                                                            resetTimeout = setTimeout(() => {
// //                                                               carouselRef.current.goTo(0)
// //                                                           }, 1500) // same time
// //                                                         }
// //                                                    }}
// //                                                     showEmptySlots>
// //                                                       {data}
// //                                                 </Carousel>
// //                                             </div>
// //                                          </div>
// //                                      </div>
// //                                  </div>
// //                              </div>
// //                          </div>
// //                      </div>
// //                  </div>
// //              </div>
// //     // <div className="App">
// //   // <div className="controls-wrapper">
// //     //     <button onClick={removeItem}>Remove Item</button>
// //     //     <button onClick={addItem}>Add Item</button>
// //     //   </div>
// //     //   <hr className="seperator" />
// //     //   <div className="carousel-wrapper">
// //     //     <Carousel breakPoints={breakPoints}>
// //     //       {items.map((item) => (
// //     //         <Item key={item}>{item}</Item>
// //     //       ))}
// //     //     </Carousel>
// //     //   </div>
// //     // </div>
// //   );
// // }


export default class ProductContainer extends Component {
    constructor(props) {
        super(props);
        this.next = this.next.bind(this);
        this.previous = this.previous.bind(this);
      }
    next() {
        this.slider.slickNext();
        // this.props.setStateOfParent(8, this.props.getId);
    }
    previous() {
        this.slider.slickPrev();
    }
  render() {
    let data = this.props.products.map((val, k) => {
        return <ProductInfo product={val}  key={k} />;
    });

    
    const settings = {
        dots: false,
        infinite: true,
        speed: 700,
        draggable: true,
        // centerMode: false,
        slidesToShow: 5,
        adaptiveHeight: true,
        // slidesToShow: 5,
        slidesToScroll: 2,
        autoplay: false,
        pauseOnHover: true,
        responsive: [
        {
        breakpoint: 1024,
        settings: {
            slidesToShow: 4,
            slidesToScroll: 2,
            infinite: true,
        },
        },
        {
        breakpoint: 768,
        settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
        },
        },
        {
        breakpoint: 600,
        settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
        },
        },
        {
        breakpoint: 480,
        settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
        },
        },
    ],

      };

    return (
        <div className="product_area product_style3 color_three">
                        <div className="container mble_responsive">
                            <div className="row mble_responsive">
                                <div className="col-12">
                                    { this.props.products.length != 0 ? (<div style={{padding: "30px 0 15px 0"}} className="section_title title_style2">
                                        <div className="title_content">
                                            <h2>{this.props.name}</h2>
                                        </div>
                                        <div className="product_tab_btn">
                                            <ul
                                                className="nav"
                                                role="tablist"
                                            >
                                                <li>
                                                    <a
                                                        className="active"
                                                        data-toggle="tab"
                                                        href="#Sellers"
                                                        role="tab"
                                                        aria-controls="Sellers"
                                                        aria-selected="true"
                                                    >
                                                        {this.props.name}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div className="seeAll">
                                            <button className="mx-1 seeMoreButton" onClick={this.previous} style={{ width: '25px',height: '25px', lineHeight: 0, borderRadius: "50%", border: "none", color:"#fff"}}>
                                                <i className="fa fa-chevron-left" aria-hidden="true" style={{ fontSize: '15px' }}></i>
                                            </button>
                                            <button className="mx-1 ml-2 seeMoreButton" onClick={this.next} style={{ width: '25px',height: '25px', lineHeight: 0, borderRadius: "50%", border: "none", color:"#fff"}}>
                                                <i className="fa fa-chevron-right" aria-hidden="true" style={{ fontSize: '15px' }}></i>
                                            </button>
                                            {/* seeAllSection */}
                                           <div style={{borderRadius:"15px"}} className="ml-3 seeMoreButton">
                                                <a style={{fontWeight: '500', color:"#fff", marginTop:"3px"}} href={BASE_URL + "shopBySection/" + this.props.getId}>See All <i className="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                                           </div>
                                            
                                        </div>
                                    </div>) : ''}
                                </div>
                            </div>

                            <div className="tab-content">
                                <div
                                    className="tab-pane fade show active"
                                    id="Sellers"
                                    role="tabpanel"
                                >
                                    <div className="product_area">
                                        <div className="container mble_responsive">
                                            <div className="row mble_responsive mb-4">
                                                <div className="col-12 mble_responsive">
                                                    <Slider ref={(c) => (this.slider = c)} {...settings} style={{ marginBottom: '40px' }}>
                                                        {data}
                                                    </Slider>
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
