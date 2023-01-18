import React, { useEffect, useState } from "react";
import { Row } from "react-bootstrap";
import {
  Card,
  CardActions,
  CardContent,
  CardHeader,
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
import CardMedicamento from "./CardMedicamento";

import SaveIcon from "@mui/icons-material/Save";
import CloseIcon from "@mui/icons-material/Close";
import AddIcon from "@mui/icons-material/Add";

function ListaMedicamentos() {
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
    const response = axios.get(endpoint + "/medicamento/verMedicamentos");
    return response;
  };

  const handleCreate = () => {
    setModalState("Crear");
    setDataModal({
      med_nombre: "",
      med_compuesto: "",
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
        endpoint + "/medicamento/crearMedicamento",
        dataModal
      );
      if (response.status === 200) {
        Swal.fire(
          "Guardado",
          "El medicamento fue guardado exitosamente!",
          "success"
        );
        handleCloseModal();
        setUpdateList(!updateList);
      } else {
        Swal.fire("Error", "Hubo un problema al procesar los datos", "error");
      }
    } else if (modalState == "Editar") {
      const response = await axios.post(
        endpoint + "/medicamento/actualizarMedicamento",
        dataModal
      );
      if (response.status === 200) {
        Swal.fire(
          "Editado",
          "El medicamento fue editado exitosamente!",
          "info"
        );
        handleCloseModal();
        setUpdateList(!updateList);
      } else {
        Swal.fire("Error", "Hubo un problema al procesar los datos", "error");
      }
    }
  };

  useEffect(() => {
    getData().then((response) => {
      setList(response.data.medicamentos);
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
          <Tooltip title="Crear nuevo medicamento">
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
          {list.map((medicamento, index) => (
            <CardMedicamento
              key={index}
              medicamento={medicamento}
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
                    {modalState} Medicamento
                  </Typography>
                }
              ></CardHeader>
              <CardContent>
                <FormControl className="mb-3">
                  <InputLabel>Nombre</InputLabel>
                  <Input
                    type="text"
                    name="med_nombre"
                    required={true}
                    id="inputnombre"
                    value={dataModal.med_nombre}
                    onChange={handleChangeModal}
                  />
                </FormControl>
                <FormControl className="mb-3">
                  <InputLabel>Compuesto</InputLabel>
                  <Input
                    type="text"
                    name="med_compuesto"
                    required={true}
                    id="inputcompuesto"
                    value={dataModal.med_compuesto}
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

export default ListaMedicamentos;
