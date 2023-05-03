import { BrowserRouter as Router, Route, Routes, NavLink, Link } from "react-router-dom";
import Sidebar from "./Sidebar";
import RawMaterials from "./RawMaterials";
import Customers from "./Customers";
import Orders from "./Orders";
import { Button } from "primereact/button";
import { InputText } from "primereact/inputtext";
import { useState } from "react";
import Models from "./Models";

import "primereact/resources/themes/lara-light-indigo/theme.css";
import "primereact/resources/primereact.min.css";
import "primeicons/primeicons.css";
import "primeflex/primeflex.css";
import "bootstrap/dist/css/bootstrap.min.css";
// import { classNames } from "primereact/utils";

import "./Login.css";
import { useRawMaterials } from "./utils/api";
import { useQuery } from "@tanstack/react-query";
import axios from "axios";
const Dashboard = () => <div>Dashboard</div>;
const Suppliers = () => <div>Suppliers</div>;

const App = () => {
	const { data, error } = useRawMaterials();

	return (
		<>
			{data ? (
				<div>
					{data.map((rawMaterial) => (
						<div key={rawMaterial.material_id_numb}>
							<p>{rawMaterial.material_name}</p>
							<p>{rawMaterial.unit_of_measurement}</p>
							<p>{rawMaterial.quantity_in_stock}</p>
							<p>{rawMaterial.reorder_point}</p>
						</div>
					))}
				</div>
			) : (
				<div>Loading...</div>
			)}
		</>

		// <Router>
		// 	<Sidebar />
		// 	<div style={{ marginLeft: "250px", padding: "20px" }}>
		// 		<Routes>
		// 			<Route path="/dashboard" element={<Dashboard />} />
		// 			<Route path="/raw-materials" element={<RawMaterials />} />
		// 			<Route path="/orders" element={<Orders />} />
		// 			<Route path="/customers" element={<Customers />} />
		// 			<Route path="/suppliers" element={<Suppliers />} />
		// 			<Route path="/models" element={<Models />} />
		// 		</Routes>
		// 	</div>
		// </Router>

		// <div className="login-page">
		// 	<div className="login-form">
		// 		<h1>Login</h1>
		// 		<form onSubmit={handleSubmit}>
		// 			<div className="p-field">
		// 				<label htmlFor="username">Username</label>
		// 				<InputText
		// 					id="username"
		// 					value={username}
		// 					onChange={(e) => setUsername(e.target.value)}
		// 					className={classNames({ "p-invalid": error })}
		// 				/>
		// 			</div>
		// 			<div className="p-field">
		// 				<label htmlFor="password">Password</label>
		// 				<InputText
		// 					id="password"
		// 					type="password"
		// 					value={password}
		// 					onChange={(e) => setPassword(e.target.value)}
		// 					className={classNames({ "p-invalid": error })}
		// 				/>
		// 			</div>
		// 			{error && <small className="p-error">Invalid username or password</small>}
		// 			<Button type="submit" label="Login"></Button>
		// 		</form>
		// 	</div>
		// </div>
	);
};

export default App;
