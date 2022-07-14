import LayoutApp from "./src/layout/app.js";
import OficinaApp from "./src/oficina/app.js";

const layout_app = new LayoutApp();
const oficina_app = new OficinaApp();
layout_app.load();
oficina_app.load();