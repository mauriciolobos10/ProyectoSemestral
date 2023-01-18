import axios from "axios";
import React from "react";
import Swal from "sweetalert2";
import {
  Card,
  CardActions,
  CardContent,
  CardHeader,
  Typography,
  Fab,
  Box,
  Tooltip,
} from "@mui/material";
import EditIcon from "@mui/icons-material/Edit";
import CloseIcon from "@mui/icons-material/Close";

const CardFarmacia = ({
  farmacia,
  setUpdateList,
  updateList,
  handleOpenModal,
  setDataModal,
  setModalState,
}) => {
  const endpoint = "http://localhost:8000/api";

  const handleDelete = async () => {
    Swal.fire({
      title: "Estas seguro de eliminar esta farmacia?",
      text: "Esto no es reversible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, eliminar!",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        axios
          .post(endpoint + "/farmacia/eliminarFarmacia", farmacia)
          .then((response) => {
            if (response.status === 200) {
              Swal.fire(
                "Eliminado",
                "La farmacia fue eliminada exitosamente!",
                "success"
              );
              setUpdateList(!updateList);
            } else {
              Swal.fire(
                "Error",
                "Hubo un problema al eliminar la farmacia",
                "error"
              );
            }
          });
      }
    });
  };
  const handleEdit = async () => {
    handleOpenModal();
    setModalState("Editar");
    setDataModal(farmacia);
  };
  return (
    <div className="col-4 mb-3">
      <Card>
        <CardHeader
          title={
            <Typography variant="h5" component="div" align="center">
              {farmacia.farm_nombre}
            </Typography>
          }
        ></CardHeader>
        <CardContent
          className="mb-2"
          sx={{ display: "flex", flexDirection: "column" }}
        >
          <Box>
            <strong>Dirección: </strong>
            {farmacia.farm_direccion}
          </Box>
          <Box>
            <strong>Mail: </strong>
            {farmacia.farm_mail}
          </Box>
        </CardContent>
        <CardActions style={{ justifyContent: "center" }}>
          <Tooltip title="Editar">
            <Fab
              onClick={handleEdit}
              size="large"
              color="warning"
              className="mb-3"
            >
              <EditIcon />
            </Fab>
          </Tooltip>
          <Tooltip title="Eliminar">
            <Fab
              onClick={handleDelete}
              size="large"
              color="danger"
              className="mb-3"
            >
              <CloseIcon />
            </Fab>
          </Tooltip>
        </CardActions>
      </Card>
    </div>
  );
};

export default CardFarmacia;
