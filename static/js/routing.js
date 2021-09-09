var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __generator = (this && this.__generator) || function (thisArg, body) {
    var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g;
    return g = { next: verb(0), "throw": verb(1), "return": verb(2) }, typeof Symbol === "function" && (g[Symbol.iterator] = function() { return this; }), g;
    function verb(n) { return function (v) { return step([n, v]); }; }
    function step(op) {
        if (f) throw new TypeError("Generator is already executing.");
        while (_) try {
            if (f = 1, y && (t = op[0] & 2 ? y["return"] : op[0] ? y["throw"] || ((t = y["return"]) && t.call(y), 0) : y.next) && !(t = t.call(y, op[1])).done) return t;
            if (y = 0, t) op = [op[0] & 2, t.value];
            switch (op[0]) {
                case 0: case 1: t = op; break;
                case 4: _.label++; return { value: op[1], done: false };
                case 5: _.label++; y = op[1]; op = [0]; continue;
                case 7: op = _.ops.pop(); _.trys.pop(); continue;
                default:
                    if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                    if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                    if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                    if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                    if (t[2]) _.ops.pop();
                    _.trys.pop(); continue;
            }
            op = body.call(thisArg, _);
        } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
        if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
    }
};
export function getPage(name, skipHistory) {
    if (name === void 0) { name = ""; }
    if (skipHistory === void 0) { skipHistory = false; }
    return __awaiter(this, void 0, void 0, function () {
        var preloader, container, url, resp, frag, _a, _b, id, el;
        return __generator(this, function (_c) {
            switch (_c.label) {
                case 0:
                    preloader = document.getElementById("preloader");
                    preloader.classList.add("show");
                    return [4, new Promise(function (resolve) { return setTimeout(resolve, 500); })];
                case 1:
                    _c.sent();
                    preloader.classList.remove("show");
                    container = document.querySelector("#content");
                    url = new URL(name, location.origin);
                    if (!url.pathname || url.pathname === "/") {
                        url.pathname = "home";
                    }
                    url.pathname.replace(/\/+$/, "");
                    container.innerHTML = "";
                    return [4, fetch("" + location.origin + url.pathname + "?render_mode=1", {
                            mode: "same-origin",
                            cache: "no-cache"
                        })];
                case 2:
                    resp = _c.sent();
                    _b = (_a = document
                        .createRange())
                        .createContextualFragment;
                    return [4, resp.text()];
                case 3:
                    frag = _b.apply(_a, [_c.sent()]);
                    container.appendChild(frag);
                    if (!skipHistory) {
                        history.pushState(url.pathname, "", "" + location.origin + url.pathname + url.hash + url.search);
                    }
                    setupLinks(container.querySelectorAll("a[href]"));
                    if (url.hash) {
                        id = url.hash.substring(1);
                        el = document.getElementById(id);
                        if (el) {
                            el.scrollIntoView({
                                block: "start",
                                inline: "nearest",
                                behavior: "smooth"
                            });
                        }
                    }
                    return [2];
            }
        });
    });
}
export function setupLinks(aLinks) {
    var _this = this;
    aLinks.forEach(function (aLink) {
        if (!(aLink instanceof HTMLAnchorElement)) {
            return;
        }
        var hrefUrl = new URL(aLink.href, location.origin);
        if (hrefUrl.origin === location.origin &&
            aLink.getAttribute("href")[0] !== "#") {
            aLink.addEventListener("click", function (ev) { return __awaiter(_this, void 0, void 0, function () {
                return __generator(this, function (_a) {
                    switch (_a.label) {
                        case 0:
                            ev.preventDefault();
                            return [4, getPage(aLink.href)];
                        case 1:
                            _a.sent();
                            return [2];
                    }
                });
            }); });
        }
    });
}
(function () { return __awaiter(void 0, void 0, void 0, function () {
    return __generator(this, function (_a) {
        setupLinks(document.querySelectorAll("nav a"));
        window.onpopstate = function () {
            getPage(location.href, true);
        };
        document.getElementById("preloader").classList.remove("show");
        return [2];
    });
}); })();
//# sourceMappingURL=routing.js.map