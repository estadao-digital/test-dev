import Alert from 'react-bootstrap/Alert';

function CustomAlert(props: any) {
    return (
        <>
            <Alert key={props.variant} variant={props.variant}>
                props.text
            </Alert>
        </>
    );
}

export default CustomAlert;