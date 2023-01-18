import React from "react";
import Container from "@mui/material/Container";
import { Typography } from "@mui/material";

import ListaFarmacias from "../components/ListaFarmacias";

export function MantenedorFarmacias() {
  return (
    <>
      <Container maxWidth="sm-12" className="mt-4">
        <Typography variant="h3" component="h4" align="center">
          Lista de farmacias
        </Typography>
      </Container>
      <ListaFarmacias />
    </>
  );
}

export default MantenedorFarmacias;
