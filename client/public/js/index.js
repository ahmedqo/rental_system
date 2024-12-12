(function() {
    const html = /*html*/ `<neo-dropdown ref="dropdown" label="{{ @trans('Actions') }}" position="{{ @state.rtl ? 'start' : 'end' }}"><button slot="trigger" part="menu-button"><svg part="menu-button-icon" viewBox="0 -960 960 960"><path d="M480.34-95Q438-95 409-124.42t-29-70.74q0-42.14 29.07-71.99Q438.13-297 479.66-297 522-297 551-267.26t29 71.5q0 41.76-29.02 71.26Q521.97-95 480.34-95Zm0-285Q438-380 409-409.07q-29-29.06-29-70.59Q380-522 409.07-551q29.06-29 70.59-29Q522-580 551-550.98q29 29.01 29 70.64Q580-438 550.98-409q-29.01 29-70.64 29Zm0-283Q438-663 409-692.95q-29-29.94-29-72Q380-807 409.07-836q29.06-29 70.59-29Q522-865 551-835.98q29 29.01 29 70.86 0 42.25-29.02 72.19Q521.97-663 480.34-663Z"/></svg></button><ul part="menu-list">{$ if @props.scene $}<li part="menu-list-item"><a href="{{ @props.scene.replace('XXX', @props.target) }}" part="menu-list-link" title="{{ @trans("View") }}"><svg part="menu-list-icon" viewBox="0 -960 960 960"><path d="M99-272q-19.325 0-32.662-13.337Q53-298.675 53-318v-319q0-20.3 13.338-33.15Q79.675-683 99-683h73q18.9 0 31.95 12.85T217-637v319q0 19.325-13.05 32.663Q190.9-272 172-272H99Zm224 96q-20.3 0-33.15-13.05Q277-202.1 277-221v-513q0-19.325 12.85-32.662Q302.7-780 323-780h314q20.3 0 33.15 13.338Q683-753.325 683-734v513q0 18.9-12.85 31.95T637-176H323Zm465-96q-18.9 0-31.95-13.337Q743-298.675 743-318v-319q0-20.3 13.05-33.15Q769.1-683 788-683h73q19.325 0 33.162 12.85Q908-657.3 908-637v319q0 19.325-13.838 32.663Q880.325-272 861-272h-73Z" /></svg><span part="menu-list-text">{{ @trans("View") }}</span></a></li>{$ endif $}{$ if @props.print $}<li part="menu-list-item"><a href="{{ @props.print.replace('XXX', @props.target) }}" part="menu-list-link" title="{{ @trans("Print") }}"><svg part="menu-list-icon" viewBox="0 -960 960 960"><path d="M741-701H220v-160h521v160Zm-17 236q18 0 29.5-10.812Q765-486.625 765-504.5q0-17.5-11.375-29.5T724.5-546q-18.5 0-29.5 12.062-11 12.063-11 28.938 0 18 11 29t29 11Zm-75 292v-139H311v139h338Zm92 86H220v-193H60v-264q0-53.65 36.417-91.325Q132.833-673 186-673h588q54.25 0 90.625 37.675T901-544v264H741v193Z"/></svg><span part="menu-list-text">{{ @trans("Print") }}</span></a></li>{$ endif $}{$ if @props.patch $}<li part="menu-list-item"><a href="{{ @props.patch.replace('XXX', @props.target) }}" part="menu-list-link" title="{{ @trans("Edit") }}"><svg part="menu-list-icon" viewBox="0 -960 960 960"><path d="M170-103q-32 7-53-14.5T103-170l39-188 216 216-188 39Zm235-78L181-405l435-435q27-27 64.5-27t63.5 27l96 96q27 26 27 63.5T840-616L405-181Z"/></svg><span part="menu-list-text">{{ @trans("Edit") }}</span></a></li>{$ endif $}{$ if @props.clear && @props.csrf $}<li part="menu-list-item"><form action="{{ @props.clear.replace('XXX', @props.target) }}" method="POST"><input type="hidden" name="_token" value="{{ @props.csrf }}" autocomplete="off" /><input type="hidden" name="_method" value="delete" /><button part="menu-list-link" title="{{ @trans("Delete") }}"><svg part="menu-list-icon" viewBox="0 -960 960 960"><path d="M253-99q-36.462 0-64.231-26.775Q161-152.55 161-190v-552h-11q-18.75 0-31.375-12.86Q106-767.719 106-787.36 106-807 118.613-820q12.612-13 31.387-13h182q0-20 13.125-33.5T378-880h204q19.625 0 33.312 13.75Q629-852.5 629-833h179.921q20.279 0 33.179 13.375 12.9 13.376 12.9 32.116 0 20.141-12.9 32.825Q829.2-742 809-742h-11v552q0 37.45-27.069 64.225Q743.863-99 706-99H253Zm104-205q0 14.1 11.051 25.05 11.051 10.95 25.3 10.95t25.949-10.95Q431-289.9 431-304v-324q0-14.525-11.843-26.262Q407.313-666 392.632-666q-14.257 0-24.944 11.738Q357-642.525 357-628v324Zm173 0q0 14.1 11.551 25.05 11.551 10.95 25.8 10.95t25.949-10.95Q605-289.9 605-304v-324q0-14.525-11.545-26.262Q581.91-666 566.93-666q-14.555 0-25.742 11.738Q530-642.525 530-628v324Z"/></svg><span part="menu-list-text">{{ @trans("Delete") }}</span></button></form></li>{$ endif $}</ul></neo-dropdown>`;

    const css = /*css */ `*{box-sizing:border-box;font-family:inherit;}[part="menu-button"]{padding:0;width:2rem;height:2rem;display:flex;align-items:center;justify-content:center;border-radius:9999px;border:unset;background-color:transparent;}[part="menu-list"]{list-style:none;display:flex;flex-direction:column;margin:0;padding:0;}[part="menu-list-link"]{display:flex;flex-wrap:wrap;align-items:center;gap:1rem;padding:0.5rem 0.75rem;font-size:1rem;font-weight:500;color:{{ @Theme.colors("BLACK") }};background:transparent;border:unset;text-decoration:solid;width:100%;}[part="menu-button"]:hover,[part="menu-button"]:focus,[part="menu-list-link"]:hover,[part="menu-list-link"]:focus {background:{{ @Theme.colors("LIGHT") }};cursor:pointer;outline:none;}[part="menu-button-icon"],[part="menu-list-icon"]{display:block;width:1.5rem;height:1.5rem;fill:currentColor;}@media(min-width:1024px){[part="menu-list"]{flex-direction:row;}[part="menu-list-text"]{display:none;}neo-dropdown::part(content){ {$ each _media into @Theme.MEDIA $} {{ _media }}animation: move-on 200ms ease-in-out forwards; {$ endeach $} }neo-dropdown::part(modal){top:50%;transform:translateY(-50%)}}`;

    Neo.Component({
        tag: "action-menu",
        tpl: html,
        css: css
    })({
        props: {
            csrf: null,
            scene: null,
            print: null,
            patch: null,
            clear: null,
            target: null,
        },
        state: {
            rtl: document.documentElement.dir === "rtl",
        },
        cycle: {
            mounted() {
                if (this.hasAttribute("csrf")) {
                    this.props.csrf = this.getAttribute("csrf");
                    this.removeAttribute("csrf");
                }

                if (this.hasAttribute("target")) {
                    this.props.target = this.getAttribute("target");
                    this.removeAttribute("target");
                }

                if (this.hasAttribute("scene")) {
                    this.props.scene = this.getAttribute("scene");
                    this.removeAttribute("scene");
                }

                if (this.hasAttribute("print")) {
                    this.props.print = this.getAttribute("print");
                    this.removeAttribute("print");
                }

                if (this.hasAttribute("patch")) {
                    this.props.patch = this.getAttribute("patch");
                    this.removeAttribute("patch");
                }

                if (this.hasAttribute("clear")) {
                    this.props.clear = this.getAttribute("clear");
                    this.removeAttribute("clear");
                }
            },
        }
    }).define();
})();

function notFound() {
    return `<svg class="block mx-auto my-4 w-20 h-20 pointer-events-none text-x-light" viewBox="0 0 49 49" fill="currentColor"><path d="M27.2849 0.318764C27.9216 0.939131 28.0719 1.50543 28.2285 2.36139C28.2617 2.53308 28.2617 2.53308 28.2956 2.70823C28.3687 3.08783 28.4397 3.46778 28.5108 3.84777C28.5623 4.11773 28.6141 4.38766 28.6659 4.65757C28.774 5.22165 28.8812 5.78588 28.9877 6.35028C29.137 7.14203 29.2886 7.93335 29.4407 8.72456C29.7065 10.1077 29.9702 11.4912 30.2334 12.8747C30.4754 14.1467 30.7178 15.4186 30.9602 16.6905C31.0208 17.0086 31.0814 17.3267 31.142 17.6448C31.6031 20.0652 32.0659 22.4853 32.5299 24.9052C32.6602 25.5853 32.7906 26.2655 32.9208 26.9456C32.9483 27.0888 32.9483 27.0888 32.9762 27.2348C33.0498 27.6186 33.1233 28.0024 33.1968 28.3861C33.4137 29.5188 33.6309 30.6515 33.8484 31.7841C33.9852 32.4968 34.1218 33.2096 34.2582 33.9224C34.3373 34.3361 34.4166 34.7497 34.4962 35.1634C34.5696 35.5445 34.6426 35.9256 34.7153 36.3069C34.7542 36.5099 34.7934 36.7129 34.8326 36.9158C35.2026 38.8603 35.2026 38.8603 35.0128 39.4119C34.9896 39.4862 34.9663 39.5606 34.9423 39.6371C34.6615 40.1077 34.2939 40.3571 33.7859 40.525C33.6405 40.5556 33.4946 40.584 33.3484 40.6107C33.266 40.6274 33.1836 40.644 33.0987 40.6612C32.8139 40.7183 32.5286 40.7724 32.2433 40.8267C32.0253 40.8697 31.8074 40.9128 31.5895 40.9561C30.8259 41.107 30.0614 41.2534 29.297 41.3998C29.0098 41.455 28.7225 41.5102 28.4353 41.5655C27.5944 41.7272 26.7533 41.8884 25.9123 42.0495C25.5191 42.1248 25.1259 42.2002 24.7327 42.2756C23.4795 42.5159 22.2263 42.7561 20.9731 42.996C19.4235 43.2925 17.874 43.59 16.325 43.8896C15.6711 44.016 15.0171 44.1418 14.3629 44.2672C13.9533 44.3457 13.5437 44.4246 13.1342 44.5045C12.6951 44.5901 12.2557 44.674 11.8163 44.7578C11.6936 44.782 11.5709 44.8062 11.4445 44.8312C9.57942 45.182 9.57942 45.182 8.86618 44.8174C8.05505 44.1884 7.97431 43.4218 7.79718 42.4546C7.76695 42.2958 7.73658 42.1371 7.7061 41.9783C7.6384 41.6242 7.57166 41.2699 7.5056 40.9155C7.39494 40.3219 7.28221 39.7287 7.16927 39.1355C7.01311 38.3144 6.85757 37.4931 6.70257 36.6718C6.30811 34.5819 5.90924 32.4928 5.51009 30.4038C5.35719 29.6036 5.20434 28.8033 5.05149 28.0031C5.01266 27.7998 4.97384 27.5966 4.93502 27.3934C4.66959 26.0038 4.40437 24.6142 4.13946 23.2245C4.10285 23.0325 4.06623 22.8404 4.02961 22.6483C3.84796 21.6956 3.6664 20.7429 3.48538 19.7901C3.39543 19.3167 3.30542 18.8433 3.21537 18.3699C3.18864 18.2293 3.18864 18.2293 3.16136 18.0858C2.91262 16.7786 2.66073 15.4719 2.40662 14.1657C2.26505 13.4378 2.1243 12.7098 1.98374 11.9818C1.86959 11.391 1.75433 10.8003 1.63822 10.2098C1.56683 9.84537 1.49652 9.48069 1.4265 9.11595C1.39409 8.94829 1.36124 8.78072 1.32789 8.61325C0.844259 6.18129 0.844259 6.18129 1.23841 5.31719C1.79714 4.74376 2.32358 4.54905 3.08738 4.41108C3.18236 4.39271 3.27734 4.37433 3.3752 4.3554C3.69263 4.29435 4.01041 4.23541 4.32823 4.17644C4.5563 4.133 4.78436 4.08942 5.01239 4.04573C5.63144 3.92747 6.25082 3.81103 6.87028 3.69493C7.51936 3.57301 8.16815 3.44962 8.81696 3.32633C9.62923 3.17208 10.4415 3.01801 11.254 2.86466C13.0692 2.52189 14.8833 2.17343 16.6968 1.82091C17.5032 1.66426 18.3098 1.50836 19.1164 1.35244C19.7629 1.22742 20.4093 1.10199 21.0555 0.97566C21.6638 0.856769 22.2724 0.739125 22.8812 0.622391C23.1038 0.579472 23.3264 0.536109 23.5489 0.492256C26.424 -0.0739328 26.424 -0.0739328 27.2849 0.318764ZM22.5186 5.16899C22.3882 5.19383 22.2579 5.21868 22.1235 5.24428C21.9799 5.27217 21.8363 5.30007 21.6927 5.32798C21.5408 5.35713 21.3889 5.38624 21.2369 5.41531C20.8247 5.49429 20.4126 5.57389 20.0005 5.6536C19.5685 5.73707 19.1363 5.81999 18.7041 5.90297C17.9778 6.0425 17.2516 6.18239 16.5254 6.32253C15.504 6.51965 14.4824 6.71617 13.4609 6.91255C12.0898 7.17614 10.7188 7.43994 9.34792 7.70437C9.20012 7.73288 9.05232 7.76137 8.90452 7.78985C8.57733 7.8529 8.25018 7.91616 7.92313 7.9799C7.70075 8.02293 7.47819 8.06502 7.25542 8.10598C7.1597 8.12394 7.06398 8.1419 6.96536 8.1604C6.88344 8.17536 6.80152 8.19031 6.71712 8.20572C6.39977 8.28935 6.25335 8.40911 6.08335 8.68729C6.03114 9.04526 6.04511 9.24934 6.20347 9.57486C6.47581 9.81997 6.68281 9.8232 7.04433 9.86182C7.33726 9.8392 7.33726 9.8392 7.63443 9.77691C7.74914 9.75537 7.86386 9.73382 7.98205 9.71163C8.10635 9.68712 8.23065 9.66262 8.35871 9.63737C8.49095 9.61221 8.62318 9.58704 8.75942 9.56112C9.12177 9.49214 9.48384 9.42179 9.84588 9.3512C10.2277 9.27699 10.6097 9.20403 10.9917 9.13092C11.6353 9.00757 12.2788 8.88343 12.9222 8.75871C13.8199 8.58469 14.7179 8.412 15.6159 8.23963C16.6151 8.04779 17.6143 7.85551 18.6133 7.66265C18.6839 7.64902 18.7545 7.63539 18.8273 7.62135C19.304 7.52925 19.7804 7.43593 20.2568 7.34242C20.7743 7.24117 21.2924 7.1451 21.8116 7.05271C21.9345 7.0301 22.0574 7.00748 22.1841 6.98418C22.4135 6.94201 22.6432 6.9014 22.8732 6.86271C23.4745 6.74999 23.8629 6.65012 24.2352 6.12468C24.2423 5.70971 24.2232 5.48221 23.9415 5.17037C23.4773 4.95115 23.0071 5.07494 22.5186 5.16899ZM23.6212 10.165C23.4412 10.1989 23.4412 10.1989 23.2576 10.2335C23.0624 10.272 23.0624 10.272 22.8633 10.3113C22.725 10.3377 22.5867 10.3641 22.4442 10.3912C22.0654 10.4635 21.6868 10.5372 21.3082 10.6111C20.9098 10.6886 20.5111 10.7649 20.1125 10.8413C19.3555 10.9867 18.5988 11.1331 17.8422 11.28C16.9895 11.4454 16.1365 11.6095 15.2835 11.7736C14.24 11.9743 13.1966 12.1754 12.1533 12.3771C12.0795 12.3914 12.0058 12.4056 11.9298 12.4203C11.4403 12.5151 10.9511 12.6107 10.4618 12.7065C9.99153 12.7984 9.5209 12.8871 9.04929 12.972C8.90031 12.9995 8.90031 12.9995 8.74832 13.0276C8.57012 13.0605 8.3917 13.0923 8.21302 13.1225C7.71975 13.2152 7.39735 13.3441 7.04433 13.7057C6.95374 14.1315 7.01043 14.2933 7.24453 14.66C8.01943 15.1715 9.33623 14.6558 10.1995 14.4903C10.3535 14.4611 10.5074 14.432 10.6613 14.4029C11.0763 14.3244 11.4912 14.2453 11.9061 14.166C12.2532 14.0997 12.6003 14.0338 12.9474 13.9678C13.7661 13.8122 14.5847 13.6562 15.4032 13.4998C16.2469 13.3387 17.0908 13.1782 17.9347 13.0182C18.6606 12.8805 19.3866 12.7423 20.1124 12.6039C20.5453 12.5213 20.9783 12.4388 21.4113 12.3568C21.818 12.2797 22.2245 12.2021 22.631 12.1241C22.78 12.0956 22.9291 12.0673 23.0782 12.0391C23.2819 12.0007 23.4855 11.9615 23.689 11.9222C23.8029 11.9005 23.9168 11.8788 24.0341 11.8564C24.4804 11.7511 24.9285 11.6443 25.1961 11.2499C25.2412 10.8972 25.2321 10.6832 25.076 10.3623C24.6616 9.98936 24.1361 10.0657 23.6212 10.165ZM24.6237 15.1787C24.5101 15.2003 24.3966 15.2218 24.2797 15.244C24.0944 15.2808 24.0944 15.2808 23.9054 15.3183C23.7744 15.3434 23.6434 15.3686 23.5084 15.3945C23.1489 15.4638 22.7897 15.5339 22.4305 15.6044C22.0517 15.6786 21.6728 15.7516 21.2938 15.8247C20.5732 15.9639 19.8528 16.1042 19.1324 16.2448C18.3237 16.4027 17.5149 16.5594 16.706 16.716C15.7148 16.9079 14.7236 17.1 13.7325 17.293C13.6624 17.3066 13.5924 17.3203 13.5201 17.3343C13.1777 17.4009 12.8353 17.4678 12.493 17.5351C11.8336 17.6643 11.174 17.7894 10.5124 17.9067C10.3847 17.9298 10.2571 17.9529 10.1256 17.9767C9.88584 18.0199 9.64589 18.0618 9.40569 18.1023C8.62193 18.2406 8.62193 18.2406 8.0053 18.7242C7.91633 19.0979 7.91633 19.0979 8.0053 19.4716C8.18591 19.7659 8.18591 19.7659 8.53918 19.8987C9.37508 19.901 10.213 19.7127 11.0299 19.553C11.156 19.5289 11.282 19.5047 11.4119 19.4799C11.7547 19.4141 12.0974 19.3478 12.44 19.2812C12.8025 19.211 13.1651 19.1413 13.5277 19.0716C14.1379 18.9542 14.748 18.8364 15.3581 18.7183C16.2088 18.5536 17.0597 18.3897 17.9106 18.2259C18.581 18.0969 19.2513 17.9676 19.9216 17.8383C19.9915 17.8248 20.0615 17.8113 20.1335 17.7974C20.8604 17.6572 21.5872 17.5164 22.3137 17.3741C22.8199 17.2751 23.3268 17.1802 23.8343 17.0878C24.0778 17.0422 24.3213 16.9966 24.5648 16.951C24.7323 16.9217 24.7323 16.9217 24.9032 16.8918C25.4961 16.7807 25.4961 16.7807 26.0131 16.4859C26.2173 16.1775 26.2175 15.9898 26.1571 15.6277C25.9533 15.3483 25.817 15.2253 25.4834 15.1306C25.1689 15.0903 24.9345 15.1183 24.6237 15.1787ZM24.1494 20.4982C23.9912 20.5283 23.8331 20.5582 23.675 20.5882C23.248 20.6692 22.8212 20.7513 22.3944 20.8338C22.0376 20.9026 21.6806 20.9708 21.3237 21.0391C20.4817 21.2 19.64 21.3619 18.7983 21.5244C17.9307 21.6919 17.0627 21.8579 16.1947 22.0233C15.4482 22.1655 14.7019 22.3086 13.9557 22.4523C13.5105 22.5381 13.0653 22.6235 12.6199 22.7082C12.2015 22.7878 11.7833 22.8684 11.3653 22.9498C11.212 22.9795 11.0586 23.0088 10.9052 23.0377C10.6955 23.0773 10.4861 23.1184 10.2768 23.1594C10.1596 23.182 10.0425 23.2045 9.92174 23.2277C9.59185 23.3197 9.35214 23.4386 9.07306 23.6358C8.92139 23.9392 8.9327 24.1542 8.96628 24.49C9.13579 24.7372 9.13579 24.7372 9.39339 24.9172C9.6904 24.9563 9.6904 24.9563 10.0154 24.9082C10.139 24.8944 10.2627 24.8807 10.3901 24.8665C11.0511 24.7717 11.7063 24.6548 12.3616 24.5272C12.5145 24.498 12.6675 24.4689 12.8204 24.4398C13.2312 24.3615 13.6419 24.2823 14.0525 24.2029C14.484 24.1195 14.9156 24.037 15.3471 23.9544C16.0706 23.8157 16.794 23.6764 17.5173 23.5367C18.3528 23.3754 19.1884 23.215 20.0242 23.0551C20.8305 22.9008 21.6366 22.7459 22.4428 22.5907C22.785 22.5248 23.1273 22.4592 23.4696 22.3937C23.8722 22.3166 24.2746 22.239 24.677 22.161C24.8244 22.1325 24.972 22.1041 25.1195 22.076C25.3211 22.0375 25.5225 21.9984 25.724 21.9591C25.8367 21.9374 25.9493 21.9157 26.0654 21.8933C26.6945 21.7472 26.6945 21.7472 27.1181 21.2868C27.1658 20.9128 27.1612 20.7174 26.9646 20.3925C26.1978 19.9063 24.9812 20.3365 24.1494 20.4982ZM25.2194 25.5166C25.0603 25.5467 24.9011 25.5767 24.742 25.6066C24.3116 25.6877 23.8815 25.7698 23.4515 25.8522C23.092 25.921 22.7324 25.9892 22.3728 26.0575C21.5245 26.2186 20.6765 26.3804 19.8285 26.5428C18.9542 26.7103 18.0797 26.8763 17.205 27.0418C16.4531 27.184 15.7014 27.327 14.9498 27.4708C14.5013 27.5565 14.0527 27.642 13.604 27.7266C13.1823 27.8062 12.7609 27.8869 12.3396 27.9683C12.1851 27.9979 12.0305 28.0273 11.8759 28.0562C11.6646 28.0958 11.4535 28.1368 11.2425 28.1779C11.1244 28.2004 11.0064 28.223 10.8847 28.2462C10.5536 28.3379 10.3139 28.4563 10.034 28.6543C9.88237 28.9576 9.89368 29.1727 9.92726 29.5085C10.0738 29.7797 10.0738 29.7797 10.3544 29.9356C11.1812 30.0034 11.9783 29.8121 12.7869 29.6564C12.9461 29.6264 13.1052 29.5964 13.2644 29.5665C13.6947 29.4853 14.1248 29.4032 14.5549 29.3209C14.9144 29.2521 15.274 29.1838 15.6336 29.1156C16.4818 28.9545 17.3299 28.7926 18.1778 28.6302C19.0521 28.4628 19.9266 28.2967 20.8013 28.1313C21.5532 27.9891 22.305 27.846 23.0566 27.7023C23.5051 27.6166 23.9537 27.5311 24.4024 27.4464C24.824 27.3668 25.2455 27.2862 25.6668 27.2048C25.8213 27.1751 25.9759 27.1458 26.1305 27.1169C26.3418 27.0773 26.5528 27.0363 26.7638 26.9952C26.8819 26.9726 27 26.9501 27.1217 26.9269C27.4528 26.8351 27.6925 26.7168 27.9723 26.5188C28.124 26.2155 28.1127 26.0004 28.0791 25.6646C27.9325 25.3934 27.9325 25.3934 27.652 25.2375C26.8252 25.1697 26.0281 25.3609 25.2194 25.5166ZM26.4404 30.4925C26.309 30.5177 26.1776 30.5428 26.0422 30.5688C25.6829 30.6378 25.3236 30.7074 24.9644 30.7774C24.5855 30.851 24.2065 30.9238 23.8274 30.9968C23.1891 31.1198 22.5508 31.2432 21.9126 31.3671C21.1016 31.5245 20.2904 31.681 19.4792 31.8373C18.7741 31.9732 18.0691 32.1094 17.3641 32.2456C17.1416 32.2886 16.9192 32.3316 16.6967 32.3745C15.8829 32.5317 15.0694 32.6906 14.2563 32.8513C13.8781 32.9253 13.4994 32.997 13.1207 33.0685C12.887 33.1141 12.6533 33.1596 12.4196 33.2053C12.3134 33.2247 12.2073 33.2442 12.0979 33.2642C11.3921 33.3973 11.3921 33.3973 10.8882 33.8863C10.8248 34.2672 10.8414 34.4495 11.0417 34.7805C11.8085 35.2668 13.0252 34.8366 13.857 34.6749C14.0151 34.6448 14.1732 34.6148 14.3314 34.5849C14.7584 34.5039 15.1852 34.4217 15.6119 34.3393C15.9688 34.2705 16.3257 34.2023 16.6827 34.134C17.5246 33.973 18.3664 33.8111 19.208 33.6487C20.0757 33.4812 20.9436 33.3151 21.8117 33.1498C22.5581 33.0075 23.3044 32.8645 24.0506 32.7207C24.4958 32.635 24.941 32.5496 25.3864 32.4649C25.8048 32.3853 26.223 32.3047 26.6411 32.2233C26.7944 32.1936 26.9477 32.1643 27.1012 32.1353C27.3108 32.0957 27.5202 32.0547 27.7296 32.0136C27.9053 31.9798 27.9053 31.9798 28.0846 31.9453C28.4176 31.8525 28.656 31.7434 28.9333 31.5372C29.076 31.1789 29.076 31.1789 29.0401 30.7898C28.8422 30.4584 28.8422 30.4584 28.5062 30.2559C27.8039 30.1915 27.1273 30.3579 26.4404 30.4925ZM28.2405 35.3721C28.1266 35.3938 28.0128 35.4155 27.8956 35.4378C27.7723 35.462 27.649 35.4861 27.5219 35.5109C27.3907 35.5361 27.2595 35.5613 27.1244 35.5872C26.765 35.6563 26.4057 35.7259 26.0465 35.7958C25.6677 35.8694 25.2887 35.9423 24.9097 36.0152C24.2711 36.1383 23.6327 36.2617 22.9943 36.3855C22.1036 36.5582 21.2128 36.7302 20.3219 36.9019C19.6213 37.037 18.9208 37.1723 18.2203 37.3077C18.147 37.3218 18.0737 37.336 17.9982 37.3506C17.7815 37.3925 17.5648 37.4344 17.3481 37.4763C17.278 37.4898 17.2079 37.5034 17.1357 37.5173C16.6627 37.6089 16.1899 37.7014 15.7171 37.7941C15.1999 37.8953 14.6822 37.9925 14.1637 38.087C14.0404 38.1101 13.917 38.1332 13.7899 38.157C13.5589 38.2002 13.3277 38.2422 13.0962 38.2827C12.507 38.3934 12.507 38.3934 11.9934 38.687C11.7908 38.9929 11.7968 39.186 11.8492 39.5454C11.9623 39.8 11.9623 39.8 12.1695 39.9725C12.5954 40.099 12.9222 40.0635 13.3549 39.9808C13.4858 39.9562 13.6168 39.9317 13.7517 39.9064C13.896 39.8783 14.0403 39.8502 14.1845 39.822C14.3372 39.793 14.4898 39.7641 14.6425 39.7353C15.0568 39.6567 15.4708 39.577 15.8848 39.4969C16.3192 39.4132 16.7537 39.3305 17.1882 39.2477C17.9187 39.1083 18.6491 38.9682 19.3794 38.8276C20.221 38.6655 21.0628 38.5043 21.9047 38.3438C22.8035 38.1723 23.7022 38.0004 24.6008 37.8281C24.8583 37.7788 25.1159 37.7296 25.3734 37.6804C25.7804 37.6025 26.1873 37.5243 26.5942 37.4458C26.7426 37.4173 26.8909 37.3888 27.0394 37.3605C27.4935 37.2738 27.9467 37.1834 28.3994 37.0895C28.5219 37.0646 28.6444 37.0397 28.7706 37.014C28.9429 36.9756 28.9429 36.9756 29.1187 36.9365C29.2196 36.9146 29.3206 36.8926 29.4246 36.87C29.7353 36.7477 29.8413 36.6329 30.001 36.3421C29.994 35.9415 29.9814 35.6947 29.7141 35.3878C29.2412 35.1705 28.7374 35.2761 28.2405 35.3721Z"/><path d="M30.215 4.73828C31.939 4.79256 33.6591 4.89544 35.3803 5.00522C35.4912 5.01224 35.6021 5.01925 35.7164 5.02648C36.039 5.04695 36.3616 5.06774 36.6841 5.08864C36.8283 5.09782 36.8283 5.09782 36.9755 5.10718C37.2491 5.12517 37.5226 5.14485 37.7961 5.16538C37.8917 5.17209 37.9874 5.1788 38.0859 5.18572C38.1796 5.19339 38.2733 5.20106 38.3698 5.20897C38.4952 5.21873 38.4952 5.21873 38.6231 5.22869C39.0467 5.30518 39.4106 5.50711 39.718 5.80604C40.0358 6.32146 40.0842 6.75818 40.0704 7.34958C40.0693 7.44156 40.0681 7.53355 40.067 7.62832C40.0421 8.96265 39.9479 10.2948 39.8609 11.6262C39.8347 12.0306 39.8092 12.4351 39.7836 12.8395C39.7336 13.6287 39.6829 14.4178 39.6318 15.2069C39.5904 15.8486 39.5492 16.4902 39.5081 17.1319C39.5023 17.2237 39.4964 17.3155 39.4904 17.41C39.4784 17.5965 39.4665 17.783 39.4546 17.9695C39.3432 19.7122 39.231 21.4548 39.1185 23.1974C39.0222 24.6901 38.9265 26.1828 38.8314 27.6755C38.7205 29.4136 38.6093 31.1517 38.4975 32.8898C38.4855 33.0754 38.4736 33.2609 38.4617 33.4464C38.4558 33.5377 38.4499 33.6289 38.4439 33.723C38.4027 34.3636 38.3617 35.0043 38.3209 35.645C38.2712 36.4261 38.2209 37.2071 38.1702 37.9881C38.1443 38.386 38.1187 38.7838 38.0935 39.1817C38.0662 39.6141 38.038 40.0465 38.0096 40.4788C38.0019 40.603 37.9942 40.7271 37.9863 40.855C37.8215 43.3176 37.8215 43.3176 37.2622 43.9249C36.6413 44.375 36.1003 44.362 35.3561 44.3224C35.2555 44.3174 35.1549 44.3124 35.0512 44.3073C33.4091 44.2217 31.7686 44.1033 30.1281 43.9904C29.667 43.9587 29.2059 43.9273 28.7448 43.8959C27.8468 43.8346 26.9488 43.7731 26.0508 43.7113C26.3416 43.4205 26.5754 43.4175 26.979 43.3414C27.0893 43.3202 27.0893 43.3202 27.2017 43.2987C27.3615 43.2681 27.5214 43.238 27.6813 43.2081C27.9351 43.1608 28.1888 43.1124 28.4424 43.0638C28.9819 42.9606 29.5217 42.8588 30.0615 42.757C30.6847 42.6394 31.3077 42.5212 31.9306 42.402C32.1792 42.3546 32.4279 42.3081 32.6766 42.2616C34.5965 41.9199 34.5965 41.9199 36.0143 40.6749C36.9304 39.2718 36.4807 37.5333 36.1779 35.9995C36.1414 35.8088 36.105 35.618 36.0688 35.4273C35.9702 34.9107 35.8698 34.3945 35.7691 33.8783C35.662 33.3277 35.5567 32.7768 35.4511 32.226C35.2711 31.2877 35.09 30.3496 34.9082 29.4116C34.6496 28.0772 34.3926 26.7426 34.1361 25.4078C33.7678 23.4912 33.3986 21.5748 33.0286 19.6585C32.4475 16.649 31.8703 13.6387 31.296 10.6279C31.1554 9.89099 31.0145 9.15415 30.8733 8.41737C30.789 7.97713 30.7048 7.53687 30.6206 7.09661C30.5827 6.89868 30.5448 6.70077 30.5068 6.50288C30.4565 6.24097 30.4065 5.97903 30.3565 5.71706C30.3419 5.64134 30.3273 5.56561 30.3122 5.48759C30.215 4.97621 30.215 4.97621 30.215 4.73828Z"/><path d="M41.6399 8.47266C41.8433 8.50774 42.0451 8.55194 42.2459 8.59945C42.4394 8.64481 42.4394 8.64481 42.6367 8.69108C42.7783 8.725 42.9198 8.75896 43.0613 8.79298C43.2055 8.82731 43.3497 8.86163 43.4939 8.89593C43.7933 8.96733 44.0925 9.03925 44.3917 9.11148C44.7574 9.19971 45.1235 9.28626 45.4897 9.37227C45.8262 9.45163 46.1621 9.53283 46.4982 9.61382C46.6228 9.64293 46.7474 9.67204 46.8758 9.70203C47.6512 9.89208 48.1698 10.0749 48.7271 10.6616C49.27 11.8309 48.7037 13.2908 48.4068 14.4721C48.3539 14.6872 48.3012 14.9024 48.2485 15.1176C48.1354 15.5791 48.0214 16.0404 47.9067 16.5015C47.7227 17.2409 47.5408 17.9808 47.3594 18.7208C47.2971 18.9747 47.2348 19.2286 47.1725 19.4824C47.1259 19.6723 47.1259 19.6723 47.0784 19.866C46.9831 20.2542 46.8875 20.6423 46.792 21.0304C46.2289 23.3173 45.6778 25.607 45.1302 27.8976C44.9762 28.5418 44.8217 29.1859 44.667 29.8299C44.6411 29.9379 44.6152 30.046 44.5885 30.1572C44.5355 30.3779 44.4825 30.5985 44.4295 30.8191C44.0217 32.5178 43.6148 34.2168 43.2092 35.916C42.9075 37.1798 42.6049 38.4433 42.3016 39.7067C42.1104 40.5033 41.9199 41.3001 41.7303 42.0971C41.5854 42.7062 41.4391 43.3151 41.2925 43.9239C41.2322 44.1752 41.1723 44.4265 41.1128 44.678C41.031 45.0234 40.9478 45.3684 40.8642 45.7134C40.8408 45.8138 40.8174 45.9142 40.7933 46.0176C40.6189 46.7278 40.4201 47.3202 39.8447 47.8061C38.9659 48.2541 38.2053 47.9964 37.288 47.7748C37.1416 47.7404 36.9952 47.7062 36.8488 47.6721C36.4602 47.5811 36.072 47.4885 35.6839 47.3955C35.3727 47.3212 35.0612 47.2479 34.7497 47.1746C33.8965 46.974 33.0442 46.77 32.1922 46.5643C31.7928 46.468 31.3932 46.3727 30.9935 46.2776C30.6816 46.2031 30.3699 46.1279 30.0582 46.0525C29.9105 46.0169 29.7628 45.9816 29.615 45.9466C29.4119 45.8985 29.209 45.8491 29.0062 45.7997C28.8913 45.7721 28.7763 45.7445 28.6578 45.716C28.5301 45.6737 28.5301 45.6737 28.3997 45.6305C28.3645 45.56 28.3293 45.4896 28.293 45.417C28.8647 45.4478 29.4364 45.479 30.008 45.5104C30.094 45.5151 30.18 45.5198 30.2686 45.5247C31.2112 45.5765 32.1535 45.6301 33.0954 45.6922C33.1702 45.6972 33.2451 45.7021 33.3222 45.7072C33.6749 45.7306 34.0276 45.7545 34.3802 45.7789C36.3657 45.9356 36.3657 45.9356 38.1163 45.0966C39.2435 44.0512 39.3612 42.7727 39.4434 41.3093C39.4547 41.1316 39.4661 40.9539 39.4777 40.7762C39.5025 40.3904 39.5262 40.0046 39.5491 39.6187C39.5864 38.9884 39.6262 38.3583 39.6662 37.7282C39.7249 36.8014 39.7824 35.8745 39.8394 34.9476C39.9338 33.4112 40.0322 31.8751 40.1311 30.339C40.1484 30.0707 40.1656 29.8025 40.1829 29.5342C40.2091 29.1272 40.2353 28.7202 40.2615 28.3132C40.3499 26.939 40.4377 25.5648 40.5254 24.1906C40.5519 23.7751 40.5784 23.3595 40.605 22.944C40.7002 21.4532 40.7951 19.9624 40.8898 18.4716C40.9656 17.2783 41.0417 16.0851 41.1182 14.8918C41.169 14.1004 41.2193 13.3089 41.2692 12.5174C41.3 12.0325 41.3311 11.5477 41.3623 11.0628C41.3768 10.8378 41.391 10.6128 41.4051 10.3878C41.4242 10.0826 41.4439 9.77732 41.4638 9.4721C41.4693 9.38216 41.4748 9.29223 41.4804 9.19956C41.5209 8.59162 41.5209 8.59162 41.6399 8.47266Z"/></svg>`;
}

function empty() {
    return "N/A";
}

function bgdate(row) {
    const now = (new Date).getTime(),
        fix = (new Date(row.dropoff_date)).getTime();

    if (row.status === "pending") {
        if (fix < now) return { background: "#fecaca" };
        if (fix - 86400 >= now) return { background: "#fef08a" };
    }
    return {};
}

function bgtick(row) {
    if (row.awaiting_response_from === "App\\Models\\User" && row.status !== 'closed') return { background: "#bbf7d0" };
    return {};
}

async function getData(url, createLinks) {
    const req = await fetch(url);
    const res = await req.json();
    createLinks && createLinks(res.prev_cursor, res.next_cursor, (new URL(url)).searchParams.get("search"));
    return res.data;
}

function searchable(field, route, callback) {
    const hidden = $query("input", field);
    var timer;

    field.addEventListener("input", e => {
        if (timer) clearTimeout(timer);
        field.loading = true;
        timer = setTimeout(async() => {
            const data = await getData(route + "?search=" + encodeURIComponent(e.target.query));
            field.data = callback(data);
            field.loading = false;
        }, 2000);
    });

    hidden && field.addEventListener("select", e => {
        hidden.value = e.detail.data.name;
    });
}

function TableVisualizer(dataVisualizer, callback, routes, rowClick, colClick) {
    var timer;
    const _routes = {
        ...$routes,
        ...routes
    }
    const Links = document.createElement("div");
    Links.innerHTML = `<a id="prev" slot="end" aria-label="prev_page_link" class="flex w-8 h-8 items-center justify-center text-x-black outline-none rounded-x-thin !bg-opacity-5 hover:bg-x-black focus:bg-x-black focus-within:bg-x-black"><svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960"><path d="M452-219 190-481l262-262 64 64-199 198 199 197-64 65Zm257 0L447-481l262-262 63 64-198 198 198 197-63 65Z" /></svg></a><a id="next" slot="end" aria-label="next_page_link" class="flex w-8 h-8 items-center justify-center text-x-black outline-none rounded-x-thin !bg-opacity-5 hover:bg-x-black focus:bg-x-black focus-within:bg-x-black"><svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960"><path d="M388-481 190-679l64-64 262 262-262 262-64-65 198-197Zm257 0L447-679l63-64 262 262-262 262-63-65 198-197Z" /></svg></a>`;

    async function event(e) {
        e.preventDefault();
        dataVisualizer.loading = true;
        dataVisualizer.setProps({
            rows: await getData(e.target.href, createLinks),
            loading: false,
        });
    }

    function createLinks(prev, next, str) {
        const search = "?search" + (str ? ("=" + str) : "");
        const preva = $query("#prev", dataVisualizer);
        const nexta = $query("#next", dataVisualizer);
        if (prev) {
            const href = $routes.search + search + "&cursor=" + prev;
            if (preva) preva.href = href
            else {
                const _preva = $query("#prev", Links).cloneNode(true);
                _preva.addEventListener("click", event);
                if (nexta) nexta.insertAdjacentElement('beforebegin', _preva);
                else dataVisualizer.insertAdjacentElement("afterbegin", _preva);
                _preva.title = $trans("Prev");
                _preva.href = href;
            }
        } else {
            if (preva) {
                preva.removeEventListener("click", event);
                preva.remove();
            }
        }
        if (next) {
            const href = $routes.search + search + "&cursor=" + next;
            if (nexta) nexta.href = href
            else {
                const _nexta = $query("#next", Links).cloneNode(true);
                _nexta.addEventListener("click", event);
                if (preva) preva.insertAdjacentElement('afterend', _nexta);
                else dataVisualizer.insertAdjacentElement("afterbegin", _nexta);
                _nexta.title = $trans("Next");
                _nexta.href = href;
            }
        } else {
            if (nexta) {
                nexta.removeEventListener("click", event);
                nexta.remove();
            }
        }
    }

    if (rowClick instanceof Function) dataVisualizer.rowClick = rowClick;
    if (rowClick === true) dataVisualizer.rowClick = function rowClick(ev, meta) {
        if (ev.target.tagName === "ACTION-MENU") return;
        window.location.href = _routes.scene.replace("XXX", meta.row.id)
    }
    if (colClick instanceof Function) dataVisualizer.colClick = colClick;

    dataVisualizer.cols = callback(_routes);

    dataVisualizer.addEventListener("search", async e => {
        e.preventDefault();
        if (timer) clearTimeout(timer);
        dataVisualizer.loading = true;
        dataVisualizer.setProps({
            rows: await new Promise((resolver, rejecter) => {
                timer = setTimeout(async() => {
                    const data = await getData(_routes.search + "?search=" +
                        encodeURIComponent(e.detail
                            .data), createLinks);
                    resolver(data);
                }, 2000);
            }),
            loading: false,
        });
    });

    (async function() {
        dataVisualizer.loading = true;
        dataVisualizer.setProps({
            rows: await getData(_routes.search + window.location.search, createLinks),
            loading: false,
        });
    })();
}

const
    $queryAll = (selector, context = document) => [...context.querySelectorAll(selector)],
    $query = (selector, context = document) => context.querySelector(selector),
    $capitalize = Neo.Helper.Str.capitalize,
    $titlize = Neo.Helper.Str.titlize,
    $routes = (() => {
        const routes = $query("meta[name=routes]");
        var $data = {};
        if (routes) {
            $data = JSON.parse(routes.content);
            routes.remove();
        }
        return { search: "", ...$data };
    })(),
    $core = (() => {
        const core = $query("meta[name=core]");
        var $data = {};
        if (core) {
            $data = JSON.parse(core.content);
            core.remove();
        }
        return $data;
    })(),
    $moment = Neo.Helper.Str.moment,
    $money = Neo.Helper.Str.money,
    $trans = Neo.Helper.trans;

const $Colors = {
    detachment: '#F97316',
    scratches: '#EAB308',
    cracks: '#22C55E',
    broken: '#6366F1',
    dents: '#D946EF',
    rust: '#EC4899'
};

$queryAll("neo-tab-wrapper").forEach(wrapper => {
    var nextTrigger, nextOutlet;

    wrapper.triggers = $queryAll("neo-tab-trigger", wrapper);
    wrapper.outlets = $queryAll("neo-tab-outlet", wrapper);

    wrapper.activate = (function activate(e) {
        wrapper.activeTrigger = nextTrigger;
        wrapper.activeOutlet = nextOutlet;

        if (!wrapper.activeTrigger || !wrapper.activeOutlet) return;

        wrapper.triggers.forEach(t => {
            t.classList.remove("bg-x-prime", "text-x-white");
            t.classList.add("text-x-black", "bg-x-white");
        });

        wrapper.outlets.forEach(t => {
            t.style.display = "none";
        });

        wrapper.activeTrigger.classList.remove("text-x-black", "bg-x-white");
        wrapper.activeTrigger.classList.add("bg-x-prime", "text-x-white");
        wrapper.activeOutlet.style.display = "";
    }).bind(wrapper);

    (new MutationObserver((mutationsList) => {
        for (const mutation of mutationsList) {
            if (mutation.type === "attributes" && mutation.attributeName === "outlet") {
                const target = wrapper.getAttribute("outlet");

                nextTrigger = wrapper.triggers.find(e => e.getAttribute("for") === target);
                nextOutlet = wrapper.outlets.find(e => e.getAttribute("name") === target);

                const ev = new CustomEvent("change:tab", {
                    bubbles: true,
                    cancelable: true,
                    composed: true,
                    isTrusted: true,
                    detail: {
                        nextTrigger,
                        nextOutlet
                    },
                });
                wrapper.dispatchEvent(ev);
                if (!ev.defaultPrevented) {
                    wrapper.activate();
                }
            }
        }
    })).observe(wrapper, { attributes: true });

    wrapper.triggers.forEach(t => {
        function active() {
            wrapper.setAttribute("outlet", t.getAttribute("for"));
        }

        t.addEventListener("click", active);
        t.addEventListener("keydown", e => {
            if (e.keyCode === 13) active();
        });
    });

    wrapper.outlets.forEach(o => {
        o.style.display = "none";
    });

    wrapper.setAttribute("outlet", wrapper.getAttribute("outlet"));
});

Neo.load(function() {
    $queryAll("neo-tab-wrapper").forEach(wrapper => {
        const tabPrev = $query("#prev", wrapper),
            tabSave = $query("#save", wrapper),
            tabNext = $query("#next", wrapper),
            track = $query("#track", wrapper);

        wrapper.addEventListener("change:tab", e => {
            if (wrapper.triggers.indexOf(wrapper.activeTrigger) < wrapper.triggers.indexOf(e.detail.nextTrigger)) {
                e.preventDefault();
                Neo.Validator.validate(wrapper.activeOutlet, {
                    ...($queryAll("[rules]", wrapper.activeOutlet).reduce((carry, item) => {
                        carry.rules[item.name] = (item.getAttribute("rules") || "").split("|");
                        carry.message.failure[item.name] = JSON.parse(item.getAttribute("errors") || "");
                        return carry;
                    }, { rules: {}, message: { failure: {} } })),
                    failure(field, __, message) {
                        Neo.Toaster.toast(message, "error");
                        field.classList.add("outline", "outline-2", "-outline-offset-2", "outline-red-400");
                    },
                    success(field) {
                        field.classList.remove("outline", "outline-2", "-outline-offset-2", "outline-red-400");
                    },
                    execute() {
                        wrapper.activate();
                    }
                });
            }

            setTimeout(() => {
                const tabIndex = wrapper.triggers.indexOf(wrapper.activeTrigger);
                tabPrev.style.display = tabIndex > 0 ? "" : "none";
                tabNext.style.display = tabIndex < wrapper.triggers.length - 1 ? "" : "none";
                tabSave.style.display = tabIndex === wrapper.triggers.length - 1 ? "" : "none";
                track.style.width = ((100 / (wrapper.triggers.length - 1)) * tabIndex) + "%";

                wrapper.triggers.forEach((t, i) => {
                    const txt = $query("span", t),
                        svg = $query("svg", t)
                    if (i < tabIndex) {
                        t.classList.add("bg-x-light");
                        t.classList.remove("bg-x-white");
                        svg.classList.remove("hidden");
                        txt.classList.add("hidden");
                        svg.classList.add("block");
                    } else {
                        txt.classList.remove("hidden");
                        svg.classList.remove("block");
                        svg.classList.add("hidden");
                    }
                });
            }, 50);
        });

        tabPrev.addEventListener("click", e => {
            const tabIndex = wrapper.triggers.indexOf(wrapper.activeTrigger);
            if (tabIndex <= 0) return;

            wrapper.setAttribute("outlet", "outlet-" + tabIndex);
        });

        tabNext.addEventListener("click", e => {
            const tabIndex = wrapper.triggers.indexOf(wrapper.activeTrigger);
            if (tabIndex >= wrapper.triggers.length - 1) return;

            wrapper.setAttribute("outlet", "outlet-" + (tabIndex + 2));
        })
    });

    $queryAll("form[validate]").forEach(form => {
        form.addEventListener("submit", e => {
            e.preventDefault();
            Neo.Validator.validate(form, {
                ...($queryAll("[rules]", form).reduce((carry, item) => {
                    carry.rules[item.name] = (item.getAttribute("rules") || "").split("|");
                    carry.message.failure[item.name] = JSON.parse(item.getAttribute("errors") || "");
                    return carry;
                }, { rules: {}, message: { failure: {} } })),
                failure(field, __, message) {
                    Neo.Toaster.toast(message, "error");
                    field.classList.add("outline", "outline-2", "-outline-offset-2", "outline-red-400");
                },
                success(field) {
                    field.classList.remove("outline", "outline-2", "-outline-offset-2", "outline-red-400");
                },
                execute() {
                    form.submit();
                }
            });
        });
    });

    $queryAll("[show-unless]").forEach(field => {
        const [target, value] = field.getAttribute("show-unless").split(",").map(e => e.trim()).filter(Boolean),
            targetField = $query("[name=" + target + "]");

        function exec() {
            if (targetField.value && targetField.value !== value) field.style.display = "";
            else field.style.display = "none";
        }

        targetField.addEventListener("change", exec);

        exec();
    });

    $queryAll("[show-if]").forEach(field => {
        const [target, value] = field.getAttribute("show-if").split(",").map(e => e.trim()).filter(Boolean),
            targetField = $query("[name=" + target + "]");

        function exec() {
            if (targetField.value === value) field.style.display = "";
            else field.style.display = "none";
        }

        targetField.addEventListener("change", exec);

        exec();
    });
});