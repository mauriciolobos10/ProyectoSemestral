import React from "react";
import Container from "@mui/material/Container";
import { Typography } from "@mui/material";

import ListaMedicamentos from "../components/ListaMedicamentos";

export function MantenedorMedicamentos() {
  return (
    <>
      <Container maxWidth="sm-12" className="mt-4">
        <Typography variant="h3" component="h4" align="center">
          Lista de medicamentos
        </Typography>
      </Container>
      <ListaMedicamentos />
    </>
  );
}

export default MantenedorMedicamentos;
