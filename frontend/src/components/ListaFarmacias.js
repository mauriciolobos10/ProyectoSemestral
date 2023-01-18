import React, { useEffect, useState } from "react";
import { Row } from "react-bootstrap";
import {
  Card,
  CardActions,
  CardContent,
  CardHeader,
  IconButton,
  Modal,
  Typography,
  FormControl,
  Input,
  InputLabel,
  Container,
  Grid,
  Fab,
  Tooltip,
} from "@mui/material";
import axios from "axios";
import Swal from "sweetalert2";
import CardFarmacia from "./CardFarmacia";

import SaveIcon from "@mui/icons-material/Save";
import CloseIcon from "@mui/icons-material/Close";
import AddIcon from "@mui/icons-material/Add";

export function ListaFarmacias() {
  const endpoint = "http://localhost:8000/api";

  const style = {
    position: "absolute",
    top: "50%",
    left: "50%",
    transform: "translate(-50%, -50%)",
    bgcolor: "background.paper",
    display: "flex",
    width: 250,
    flexDirection: "column",
    boxShadow: 24,
  };

  const [list, setList] = useState([]);
  const [dataModal, setDataModal] = useState({});
  const [modalState, setModalState] = useState("Crear");
  const [updateList, setUpdateList] = useState(false);
  const [openModal, setOpenModal] = useState(false);

  const getData = async () => {
    const response = axios.get(endpoint + "/farmacia/verFarmacias");
    return response;
  };

  const handleCreate = () => {
    setModalState("Crear");
    setDataModal({
      farm_nombre: "",
      farm_direccion: "",
      farm_mail: "",
    });
    handleOpenModal();
  };

  const handleOpenModal = () => {
    setOpenModal(true);
  };

  const handleCloseModal = () => {
    setOpenModal(false);
  };

  const handleChangeModal = ({ target }) => {
    setDataModal({
      ...dataModal,
      [target.name]: target.value,
    });
  };

  const handleModalSubmit = async (e) => {
    e.preventDefault();
    if (modalState == "Crear") {
      const response = await axios.post(
        endpoint + "/farmacia/crearFarmacia",
        dataModal
      );
      if (response.status === 200) {
        Swal.fire(
          "Guardado",
          "La Farmacia fue guardada exitosamente!",
          "success"
        );
        handleCloseModal();
        setUpdateList(!updateList);
      } else {
        Swal.fire("Error", "Hubo un problema al procesar los datos", "error");
      }
    } else if (modalState == "Editar") {
      const response = await axios.post(
        endpoint + "/farmacia/actualizarFarmacia",
        dataModal
      );
      if (response.status === 200) {
        Swal.fire("Editado", "La farmacia fue editada exitosamente!", "info");
        handleCloseModal();
        setUpdateList(!updateList);
      } else {
        Swal.fire("Error", "Hubo un problema al procesar los datos", "error");
      }
    }
  };

  useEffect(() => {
    getData().then((response) => {
      setList(response.data.farmacias);
    });
  }, [updateList]);

  return (
    <>
      <Grid
        container
        spacing={0}
        direction="column"
        alignItems="center"
        justifyContent="center"
      >
        <Grid item xs={3}>
          <Tooltip title="Crear nueva farmacia">
            <Fab
              onClick={handleCreate}
              size="medium"
              color="success"
              className="mb-3 mt-1"
            >
              <AddIcon />
            </Fab>
          </Tooltip>
        </Grid>
      </Grid>

      <Container className="mb-5">
        <Row>
          {list.map((farmacia, index) => (
            <CardFarmacia
              key={index}
              farmacia={farmacia}
              setUpdateList={setUpdateList}
              updateList={updateList}
              handleOpenModal={handleOpenModal}
              setDataModal={setDataModal}
              setModalState={setModalState}
            />
          ))}
        </Row>

        <Modal open={openModal} onClose={handleCloseModal}>
          <form onSubmit={handleModalSubmit}>
            <Card sx={style}>
              <CardHeader
                title={
                  <Typography variant="h5" component="div">
                    {modalState} Farmacia
                  </Typography>
                }
              ></CardHeader>
              <CardContent>
                <FormControl className="mb-3">
                  <InputLabel>Nombre</InputLabel>
                  <Input
                    type="text"
                    name="farm_nombre"
                    required={true}
                    id="inputnombre"
                    color="success"
                    value={dataModal.farm_nombre}
                    onChange={handleChangeModal}
                  />
                </FormControl>
                <FormControl className="mb-3">
                  <InputLabel>Dirección</InputLabel>
                  <Input
                    type="text"
                    name="farm_direccion"
                    required={true}
                    id="inputdireccion"
                    value={dataModal.farm_direccion}
                    onChange={handleChangeModal}
                  />
                </FormControl>
                <FormControl className="mb-3">
                  <InputLabel>Mail</InputLabel>
                  <Input
                    type="text"
                    name="farm_mail"
                    required={true}
                    id="inputmail"
                    value={dataModal.farm_mail}
                    onChange={handleChangeModal}
                  />
                </FormControl>
              </CardContent>
              <CardActions>
                <Tooltip title="Guardar">
                  <Fab
                    type="submit"
                    size="medium"
                    color="primary"
                    className="mb-3 mt-1"
                  >
                    <SaveIcon />
                  </Fab>
                </Tooltip>
                <Tooltip title="Cancelar">
                  <Fab
                    onClick={handleCloseModal}
                    size="medium"
                    color="error"
                    className="mb-3 mt-1"
                  >
                    <CloseIcon />
                  </Fab>
                </Tooltip>
              </CardActions>
            </Card>
          </form>
        </Modal>
      </Container>
    </>
  );
}

export default ListaFarmacias;
