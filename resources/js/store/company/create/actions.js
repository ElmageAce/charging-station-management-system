import * as types from "./actionTypes";
import httpRequest from "../../../utils/http";

const createCreateRequestAction = () => ({type: types.COMPANY_CREATE_REQUEST})
const createCreateSuccessAction = (data) => ({type: types.COMPANY_CREATE_SUCCESS, data})
const createCreateFailureAction = (error) => ({type: types.COMPANY_CREATE_FAILURE, error})

export const sendCompanyCreateRequest = (data) => dispatch => {
    dispatch(createCreateRequestAction())

    const callbacks = {
        success: createCreateSuccessAction,
        failure: createCreateFailureAction
    }

    dispatch(httpRequest({url: '/api/company', method: 'post', data}, callbacks))
}
