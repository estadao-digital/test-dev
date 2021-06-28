import { toast } from 'react-toastify'
import 'react-toastify/dist/ReactToastify.css'

export async function handleResponse(response) {
  if (response.ok) return response.json();
  if (response.status !== 200) {
    const error = await response.json();
    toast.error(error.message)
    throw new Error(error.message);
  }
  throw new Error("Network response was not ok.");
}

export function handleError(error) {
  // eslint-disable-next-line no-console
  console.error("API call failed. " + error);
  throw error;
}
