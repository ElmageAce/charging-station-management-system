import * as types from './actionTypes'
import httpRequest from "../../../utils/http";

const createShowRequestAction = () => ({type: types.COMPANY_SHOW_REQUEST})
const createShowSuccessAction = (data) => ({type: types.COMPANY_SHOW_SUCCESS, data})
const createShowFailureAction = (error) => ({type: types.COMPANY_SHOW_FAILURE, error})

export const sendCompanyShowRequest = (id) => dispatch => {
    dispatch(createShowRequestAction())
    const callbacks = {
        success: (data) => dispatch => {
            console.log('inio', data)
            dispatch(createShowSuccessAction(data))
        },
        failure: createShowFailureAction
    }

    dispatch(httpRequest({url: '/api/company/' + id, method: 'get'}, callbacks))
};
