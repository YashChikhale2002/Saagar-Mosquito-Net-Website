document.addEventListener("DOMContentLoaded", (event) => {
    // preloader
    // const preloader = document.getElementById('preloader');
    // preloader.style.display = 'none';
    // document.body.style.position = 'static';

    // HEADER NAV IN MOBILE
    if (document.querySelector(".ul-header-nav")) {
        const ulSidebar = document.querySelector(".ul-sidebar");
        const ulSidebarOpener = document.querySelector(".ul-header-sidebar-opener");
        const ulSidebarCloser = document.querySelector(".ul-sidebar-closer");
        const ulMobileMenuContent = document.querySelector(".to-go-to-sidebar-in-mobile");
        const ulHeaderNavMobileWrapper = document.querySelector(".ul-sidebar-header-nav-wrapper");
        const ulHeaderNavOgWrapper = document.querySelector(".ul-header-nav-wrapper");

        function updateMenuPosition(log) {
            if (window.innerWidth < 992) {
                ulHeaderNavMobileWrapper.appendChild(ulMobileMenuContent);
            }

            if (window.innerWidth >= 992) {
                ulHeaderNavOgWrapper.appendChild(ulMobileMenuContent);
            }
        }

        updateMenuPosition("running.........................");

        window.addEventListener("resize", () => {
            updateMenuPosition("on resixe");
        });

        ulSidebarOpener.addEventListener("click", () => {
            ulSidebar.classList.add("active");
        });

        ulSidebarCloser.addEventListener("click", () => {
            ulSidebar.classList.remove("active");
        });


        // menu dropdown/submenu in mobile
        const ulHeaderNavMobile = document.querySelector(".ul-header-nav");
        const ulHeaderNavMobileItems = ulHeaderNavMobile.querySelectorAll(".has-sub-menu");
        ulHeaderNavMobileItems.forEach((item) => {
            if (window.innerWidth < 992) {
                item.addEventListener("click", () => {
                    item.classList.toggle("active");
                });
            }
        });
    }

    // header search in mobile start
    const ulHeaderSearchOpener = document.querySelector(".ul-header-search-opener");
    const ulHeaderSearchCloser = document.querySelector(".ul-search-closer");
    if (ulHeaderSearchOpener) {
        ulHeaderSearchOpener.addEventListener("click", () => {
            document.querySelector(".ul-search-form-wrapper").classList.add("active");
        });
    }

    if (ulHeaderSearchCloser) {
        ulHeaderSearchCloser.addEventListener("click", () => {
            document.querySelector(".ul-search-form-wrapper").classList.remove("active");
        });
    }
    // header search in mobile end


    // sticky header
    const ulHeader = document.querySelector(".to-be-sticky");
    if (ulHeader) {
        window.addEventListener("scroll", () => {
            if (window.scrollY > 80) {
                ulHeader.classList.add("sticky");
            } else {
                ulHeader.classList.remove("sticky");
            }
        });
    }

    // wow js - animation on scroll
    new WOW({}).init();



    // Banner slider
    new Swiper(".ul-banner-slider", {
        slidesPerView: 1,
        spaceBetween: 15,
        autoplay: true,
        loop: true,
        pagination: {
            el: ".ul-banner-slider-pagination"
        }
    });

    // market accordion image
    const accordionItems = document.querySelectorAll(".ul-single-accordion-item");
    const dynamicImage = document.getElementById("ul-market-accordion-img");

    if (accordionItems) {
        accordionItems.forEach((item) => {
            item.addEventListener("click", function () {
                const newImg = item.getAttribute("data-img");
                if (newImg) {
                    dynamicImage.src = newImg;
                }
            });
        });
    }

    // INDEX-2 banner slider
    new Swiper(".ul-2-banner-slider", {
        slidesPerView: 1,
        loop: true,
        autoplay: true,
        pagination: {
            el: ".ul-2-banner-slider-pagination",
            clickable: true,
        }
    });

    // INDEX-2 clients slider
    new Swiper(".ul-2-clients-slider", {
        slidesPerView: 8,
        spaceBetween: 79,
        loop: true,
        autoplay: true,
        breakpoints: {
            1200: {
                slidesPerView: 8,
            },
            992: {
                slidesPerView: 5,
            },
            768: {
                slidesPerView: 4,
            },
            576: {
                slidesPerView: 3,
            },
            480: {
                slidesPerView: 3,
            },
            0: {
                slidesPerView: 2,
            }
        }
    });

    // index-2 team slider
    new Swiper(".ul-2-team-slider", {
        slidesPerView: 3.40,
        spaceBetween: 27,
        loop: true,
        navigation: {
            prevEl: "#ul-2-team-slider-nav .prev",
            nextEl: "#ul-2-team-slider-nav .next"
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            480: {
                spaceBetween: 20,
                slidesPerView: 2,
            },
            576: {
                spaceBetween: 20,
                slidesPerView: 2.3,
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 24,
            },
            1200: {
                slidesPerView: 3.40,
                spaceBetween: 27,
            }
        }
    });

    // index-2 testimonial slider
    new Swiper(".ul-2-testimonials-slider", {
        slidesPerView: 3.15,
        spaceBetween: 27,
        centeredSlides: true,
        loop: true,
        freeMode: true,
        autoplay: true,
        breakpoints: {
            0: {
                slidesPerView: 1.1,
                spaceBetween: 20,
            },
            480: {
                slidesPerView: 1.5,
                spaceBetween: 20,
            },
            576: {
                slidesPerView: 1.7,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            992: {
                slidesPerView: 2.5,
                spaceBetween: 25,
            },
            1200: {
                slidesPerView: 3.15,
                spaceBetween: 27,
            }
        }
    });


    // ticker
    const script = document.createElement("script");
    script.src = "https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js";
    script.async = true;
    script.innerHTML = JSON.stringify({
        symbols: [
            { proName: "FOREXCOM:SPXUSD", title: "S&P 500 Index" },
            { proName: "FOREXCOM:NSXUSD", title: "US 100 Cash CFD" },
            { proName: "FX_IDC:EURUSD", title: "EUR to USD" },
            { proName: "BITSTAMP:BTCUSD", title: "Bitcoin" },
            { proName: "BITSTAMP:ETHUSD", title: "Ethereum" },
            { proName: "OANDA:XAUUSD", title: "Gold" }
        ],
        colorTheme: "dark",
        locale: "en",
        largeChartUrl: "",
        isTransparent: true,
        showSymbolLogo: true,
        displayMode: "adaptive"
    });

    const script2 = document.createElement("script");
    script2.src = "https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js";
    script2.async = true;
    script2.innerHTML = JSON.stringify({
        "symbols": [
            {
                "proName": "NASDAQ:TSLA",
                "title": "Tesla"
            },
            {
                "proName": "NASDAQ:NVDA",
                "title": "Nvidia"
            },
            {
                "proName": "NASDAQ:AAPL",
                "title": "Apple"
            },
            {
                "proName": "NASDAQ:GOOGL",
                "title": "Google"
            },
            {
                "proName": "NASDAQ:AMZN",
                "title": "Amazon"
            },
            {
                "proName": "NASDAQ:NFLX",
                "title": "Netflix"
            }
        ],
        "colorTheme": "dark",
        "locale": "en",
        "largeChartUrl": "",
        "isTransparent": true,
        "showSymbolLogo": true,
        "displayMode": "adaptive"
    });

    // Append to desired container
    if (document.getElementById("ticker-tape-container")) {
        document.getElementById("ticker-tape-container").appendChild(script);
    }
    if (document.getElementById("ticker-tape-container-2")) {
        document.getElementById("ticker-tape-container-2").appendChild(script2);
    }


    // about page history slider
    const historyYearsSlider = new Swiper(".ul-history-years-slider", {
        slidesPerView: 6,
        watchSlidesProgress: true,
        slideToClickedSlide: true,
        freeMode: true,
        breakpoints: {
            0: {
                slidesPerView: 3,
            },
            480: {
                slidesPerView: 4,
            },
            576: {
                slidesPerView: 5,
            },
            768: {
                slidesPerView: 6,
            }
        }
    });

    const historySlider = new Swiper(".ul-history-slider", {
        autoplay: true,
        navigation: {
            prevEl: ".ul-history-slider-nav .prev",
            nextEl: ".ul-history-slider-nav .next"
        },
        thumbs: {
            swiper: historyYearsSlider,
        }
    });


    // index-2 market overview widget
    const marketOverview = document.querySelector("#ul-market-overview-widget-wrapper script");
    if (marketOverview) {
        marketOverview.src = "https://s3.tradingview.com/external-embedding/embed-widget-market-overview.js";
        marketOverview.async = true;
        marketOverview.innerHTML = JSON.stringify({
            "colorTheme": "light",
            "dateRange": "12M",
            "locale": "en",
            "largeChartUrl": "",
            "isTransparent": false,
            "showFloatingTooltip": false,
            "plotLineColorGrowing": "rgba(255, 0, 0, 1)",
            "plotLineColorFalling": "rgba(255, 0, 0, 1)",
            "gridLineColor": "rgba(240, 243, 250, 0)",
            "scaleFontColor": "#0F0F0F",
            "belowLineFillColorGrowing": "rgba(255, 0, 0, 0.12)",
            "belowLineFillColorFalling": "rgba(255, 0, 0, 0.12)",
            "belowLineFillColorGrowingBottom": "rgba(255, 0, 0, 0)",
            "belowLineFillColorFallingBottom": "rgba(255, 0, 0, 0)",
            "symbolActiveColor": "rgba(255, 0, 0, 0.12)",
            "tabs": [
                {
                    "title": "Indices",
                    "symbols": [
                        {
                            "s": "FOREXCOM:SPXUSD",
                            "d": "S&P 500 Index"
                        },
                        {
                            "s": "FOREXCOM:NSXUSD",
                            "d": "US 100 Cash CFD"
                        },
                        {
                            "s": "FOREXCOM:DJI",
                            "d": "Dow Jones Industrial Average Index"
                        },
                        {
                            "s": "INDEX:NKY",
                            "d": "Japan 225"
                        },
                        {
                            "s": "INDEX:DEU40",
                            "d": "DAX Index"
                        },
                        {
                            "s": "FOREXCOM:UKXGBP",
                            "d": "FTSE 100 Index"
                        }
                    ],
                    "originalTitle": "Indices"
                },
                {
                    "title": "Futures",
                    "symbols": [
                        {
                            "s": "BMFBOVESPA:ISP1!",
                            "d": "S&P 500"
                        },
                        {
                            "s": "BMFBOVESPA:EUR1!",
                            "d": "Euro"
                        },
                        {
                            "s": "CMCMARKETS:GOLD",
                            "d": "Gold"
                        },
                        {
                            "s": "PYTH:WTI3!",
                            "d": "WTI Crude Oil"
                        },
                        {
                            "s": "BMFBOVESPA:CCM1!",
                            "d": "Corn"
                        }
                    ],
                    "originalTitle": "Futures"
                },
                {
                    "title": "Bonds",
                    "symbols": [
                        {
                            "s": "EUREX:FGBL1!",
                            "d": "Euro Bund"
                        },
                        {
                            "s": "EUREX:FBTP1!",
                            "d": "Euro BTP"
                        },
                        {
                            "s": "EUREX:FGBM1!",
                            "d": "Euro BOBL"
                        }
                    ],
                    "originalTitle": "Bonds"
                },
                {
                    "title": "Forex",
                    "symbols": [
                        {
                            "s": "FX:EURUSD",
                            "d": "EUR to USD"
                        },
                        {
                            "s": "FX:GBPUSD",
                            "d": "GBP to USD"
                        },
                        {
                            "s": "FX:USDJPY",
                            "d": "USD to JPY"
                        },
                        {
                            "s": "FX:USDCHF",
                            "d": "USD to CHF"
                        },
                        {
                            "s": "FX:AUDUSD",
                            "d": "AUD to USD"
                        },
                        {
                            "s": "FX:USDCAD",
                            "d": "USD to CAD"
                        }
                    ],
                    "originalTitle": "Forex"
                }
            ],
            "support_host": "https://www.tradingview.com",
            "width": "400",
            "height": "550",
            "showSymbolLogo": true,
            "showChart": true
        })
    }


    // index-2 event widget
    const eventWidget = document.querySelector("#ul-event-widget-wrapper script");
    if (eventWidget) {
        eventWidget.src = "https://s3.tradingview.com/external-embedding/embed-widget-events.js";
        eventWidget.async = true;
        eventWidget.innerHTML = JSON.stringify({
            "colorTheme": "light",
            "isTransparent": false,
            "locale": "en",
            "countryFilter": "ar,au,br,ca,cn,fr,de,in,id,it,jp,kr,mx,ru,sa,za,tr,gb,us,eu",
            "importanceFilter": "0,1",
            "width": "100%",
            "height": "100%"
        })
    };


    // login modal
    const loginOpener = document.querySelector(".login-opener");
    const loginModal = document.querySelector("#login-form-modal");
    const loginModalCloser = loginModal.querySelector(".ul-form-modal-closer");
    if (loginOpener) {
        loginOpener.addEventListener("click", (e) => {
            e.preventDefault();
            document.documentElement.classList.add("overflow-hidden");
            loginModal.classList.add("active");
        });
    }

    if (loginModalCloser) {
        loginModalCloser.addEventListener("click", () => {
            loginModal.classList.remove("active");
            document.documentElement.classList.remove("overflow-hidden");
        });
    }


    // login modal
    const loanApplyOpeners = document.querySelectorAll(".loan-apply-opener");
    const loanApplyModal = document.querySelector("#loan-apply-form-modal");
    const loanApplyModalCloser = loanApplyModal.querySelector(".ul-form-modal-closer");
    loanApplyOpeners.forEach((loanApplyOpener) => {
        if (loanApplyOpener) {
            loanApplyOpener.addEventListener("click", (e) => {
                e.preventDefault();
                document.documentElement.classList.add("overflow-hidden");
                loanApplyModal.classList.add("active");
            });
        }

        if (loanApplyModalCloser) {
            loanApplyModalCloser.addEventListener("click", () => {
                loanApplyModal.classList.remove("active");
                document.documentElement.classList.remove("overflow-hidden");
            });
        }
    });
});

