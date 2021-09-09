/**
 * Fetch a page and show it
 *
 * @param {string} name The page's name. `page_accueil` by default
 * @param {boolean} skipHistory If we want to skip `history.pushState`. `false` by default
 * @returns {Promise<void>}
 */
export async function getPage(
	name: string = "",
	skipHistory: boolean = false
): Promise<void> {
	// Hiding preloader
	const preloader = document.getElementById("preloader");
	preloader.classList.add("show");
	await new Promise((resolve) => setTimeout(resolve, 500));
	preloader.classList.remove("show");

	const container = document.querySelector("#content");
	const url = new URL(name, location.origin);
	if (!url.pathname || url.pathname === "/") {
		url.pathname = "home";
	}
	url.pathname.replace(/\/+$/, ""); // Removing trailing /

	container.innerHTML = "";
	const resp = await fetch(`${location.origin}${url.pathname}?render_mode=1`, {
		mode: "same-origin",
		cache: "no-cache",
	});

	const frag = document
		.createRange()
		.createContextualFragment(await resp.text());
	container.appendChild(frag);

	if (!skipHistory) {
		history.pushState(
			url.pathname,
			"",
			`${location.origin}${url.pathname}${url.hash}${url.search}`
		);
	}

	setupLinks(container.querySelectorAll("a[href]"));

	// Scroll to anchor if needed
	if (url.hash) {
		const id = url.hash.substring(1);
		const el = document.getElementById(id);
		if (el) {
			el.scrollIntoView({
				block: "start",
				inline: "nearest",
				behavior: "smooth",
			});
		}
	}
}

/**
 * Override default behaviour of a link
 * @param {NodeListOf<Element>} aLinks
 */
export function setupLinks(aLinks: NodeListOf<Element>) {
	aLinks.forEach((aLink) => {
		// Skipping other elements than <a>
		if (!(aLink instanceof HTMLAnchorElement)) {
			return;
		}
		const hrefUrl = new URL(aLink.href, location.origin);
		// Avoiding to override externals links and anchors links
		if (
			hrefUrl.origin === location.origin &&
			aLink.getAttribute("href")[0] !== "#"
		) {
			aLink.addEventListener("click", async (ev) => {
				ev.preventDefault();
				await getPage(aLink.href);
			});
		}
	});
}

(async () => {
	setupLinks(document.querySelectorAll("nav a"));
	// Getting page if back/next is pressed
	window.onpopstate = function () {
		getPage(location.href, true);
	};

	document.getElementById("preloader").classList.remove("show");
})();
