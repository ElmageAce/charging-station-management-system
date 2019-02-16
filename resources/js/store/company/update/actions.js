import * as types from "./actionTypes";
import httpRequest from "../../../utils/http";

const createUpdateRequestAction = () => ({type: types.COMPANY_UPDATE_REQUEST})
const createUpdateSuccessAction = (data) => ({type: types.COMPANY_UPDATE_SUCCESS, data})
const createUpdateFailureAction = (error) => ({type: types.COMPANY_UPDATE_FAILURE, error})

export const sendCompanyUpdateRequest = (company, data) => dispatch => {
    dispatch(createUpdateRequestAction())

    const callbacks = {
        success: createUpdateSuccessAction,
        failure: createUpdateFailureAction
    }

    dispatch(httpRequest({url: '/api/company/' + company.id, method: 'put', data}, callbacks))
}
