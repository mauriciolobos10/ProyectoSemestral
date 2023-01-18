import React from "react";
import { Outlet, Link } from "react-router-dom";

import AppBar from "@mui/material/AppBar";
import Box from "@mui/material/Box";
import Toolbar from "@mui/material/Toolbar";
import IconButton from "@mui/material/IconButton";

import { Container, Nav, Navbar } from "react-bootstrap";

import MenuIcon from "@mui/icons-material/Menu";

export function Mantenedor() {
  return (
    <>
      <Navbar bg="dark" variant="dark">
        <Container fluid>
          <Link className="navbar-brand">Mantenedor</Link>
          <Nav className="me-auto">
            <Link to="/mantenedor/centros" className="nav-link">Centros
            </Link>
            <Link to="/mantenedor/farmacias" className="nav-link">Farmacias
            </Link>
            <Link to="/mantenedor/medicamentos" className="nav-link">Medicamentos
            </Link>
          </Nav>
        </Container>
      </Navbar>

      <Outlet />
    </>
  );
}

export default Mantenedor;
