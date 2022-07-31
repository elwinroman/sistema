import LayoutApp from "./src/layout/app.js";
import OficinaApp from "./src/oficina/app.js";
import CargoApp from './src/cargo/app.js';

const layout_app = new LayoutApp();
const oficina_app = new OficinaApp();
const cargo_app = new CargoApp();

layout_app.load();
oficina_app.load();
cargo_app.load();