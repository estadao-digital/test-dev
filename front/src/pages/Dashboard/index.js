import React, { useState, useEffect } from 'react';
import { useSelector } from 'react-redux';
import { withStyles, makeStyles } from '@material-ui/core/styles';

import {
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
  IconButton,
  Grid,
  Paper,
} from '@material-ui/core';
import { MdDelete, MdEdit, MdAdd } from 'react-icons/md';

import api from '../../services/api';

import { FabButton } from './styles';
import Cadastrar from '../Carros/Cadastrar';
import Editar from '../Carros/Editar';
import Deletar from '../Carros/Deletar';

const StyledTableCell = withStyles(theme => ({
  head: {
    backgroundColor: theme.palette.common.black,
    color: theme.palette.common.white,
  },
  body: {
    fontSize: 14,
  },
}))(TableCell);

const StyledTableRow = withStyles(theme => ({
  root: {
    '&:nth-of-type(odd)': {
      backgroundColor: theme.palette.action.hover,
    },
  },
}))(TableRow);

const useStyles = makeStyles({
  table: {
    minWidth: 700,
  },
});

const Dashboard = () => {
  const [data, setData] = useState([]);
  const [marcas, setMarcas] = useState([]);
  const [carros, setCarros] = useState([]);
  const [opened, setOpened] = useState(false);
  const [updated, setUpdated] = useState(false);
  const [deletar, setDeletar] = useState(false);

  useEffect(() => {
    async function loadMarcas() {
      const response = await api.get('marcas');

      setMarcas(response.data);
    }
    loadMarcas();
  }, []);

  async function loadCarros() {
    const response = await api.get('carros');
    setCarros(response.data);
  }

  useSelector(state => {
    if (state.carro.reload === true) {
      loadCarros();
    }
  });

  function handleEdit(carro) {
    setData(carro);
    setUpdated(true);
  }
  function handleDelete(carro) {
    setData(carro);
    setDeletar(true);
  }

  useEffect(() => {
    loadCarros();
  }, []);

  const classes = useStyles();

  return (
    <div>
      <Grid container justify="flex-end">
        <Grid item>
          <FabButton
            color="secondary"
            aria-label="add"
            onClick={() => setOpened(!opened)}
          >
            <MdAdd />
          </FabButton>
        </Grid>
      </Grid>

      <TableContainer component={Paper}>
        <Table className={classes.table} aria-label="customized table">
          <TableHead>
            <TableRow>
              <StyledTableCell>ID</StyledTableCell>
              <StyledTableCell align="left">Marca</StyledTableCell>
              <StyledTableCell align="left">Modelo</StyledTableCell>
              <StyledTableCell align="left">Ano</StyledTableCell>
              <StyledTableCell align="right">Edit</StyledTableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {carros.map(carro => (
              <StyledTableRow key={carro.id}>
                <StyledTableCell component="th" scope="row">
                  {carro.id}
                </StyledTableCell>
                <StyledTableCell align="left">
                  {carro.nome_marca}
                </StyledTableCell>
                <StyledTableCell align="left">{carro.modelo}</StyledTableCell>
                <StyledTableCell align="left">{carro.ano}</StyledTableCell>
                <StyledTableCell align="right">
                  <IconButton
                    aria-label="edit"
                    onClick={() => handleEdit(carro)}
                  >
                    <MdEdit />
                  </IconButton>
                  <IconButton
                    aria-label="delete"
                    onClick={() => handleDelete(carro)}
                  >
                    <MdDelete />
                  </IconButton>
                </StyledTableCell>
              </StyledTableRow>
            ))}
          </TableBody>
        </Table>
      </TableContainer>

      <Cadastrar onChange={setOpened} open={opened} marcas={marcas} />
      <Editar
        onChange={setUpdated}
        open={updated}
        data={data}
        marcas={marcas}
      />
      <Deletar onChange={setDeletar} open={deletar} data={data} />
    </div>
  );
};

export default Dashboard;
