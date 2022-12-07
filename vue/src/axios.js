import axios from "axios";

axios.defaults.baseURL = "http://127.0.0.1:8000/api/";
const addHeader = () => {
  axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');
}

export default addHeader;