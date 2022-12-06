import React, { useState } from 'react';
import Button from 'react-bootstrap/Button';
import Modal from 'react-bootstrap/Modal';
import { FaCheck } from 'react-icons/fa';

function ModalConfirm(props: any) {
  const [show, setShow] = useState(false);
  const handleClose = () => setShow(false);
  const handleShow = () => setShow(true);

  // const handleConfirm = (e, url, method) => {

  // }

  return (

    <>
      <Button onClick={handleShow}>
        {props.buttonContent}
      </Button>
      <Modal.Dialog>
        <Modal.Header closeButton>
          <Modal.Title>{props.title}</Modal.Title>
        </Modal.Header>

        {props.text &&
          <Modal.Body>
            <p>props.text</p>
          </Modal.Body>
        }

        <Modal.Footer>
          <Button variant="secondary" onClick={handleClose}>
            Close
          </Button>
          <Button variant="primary">{props.confirmButtonText}<FaCheck /></Button>
        </Modal.Footer>
      </Modal.Dialog>
      );
    </>
  )

}
export default ModalConfirm;
