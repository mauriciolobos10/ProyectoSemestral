import React from "react";
import Container from "@mui/material/Container";
import { Typography } from "@mui/material";

import ListaCentros from "../components/ListaCentros";

export function MantenedorCentros() {
  return (
    <>
      <Container maxWidth="sm-12" className="mt-4">
          <Typography variant="h3" component="h4" align="center">
            Lista de centros
          </Typography>
      </Container>
        <ListaCentros/>
    </>
  );
}

export default MantenedorCentros;