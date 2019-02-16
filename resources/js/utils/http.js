const httpRequest = (
    config = {url: '/', method: 'get', params: {}, data: {}},
    callbacks = {success: () => ({type: 'NA'}), failure: () => ({type: 'NA'})}
) => dispatch => {
    axios.request(config).then(
        response => dispatch(callbacks.success(response.data))
    ).catch(
        error => dispatch(callbacks.failure(error))
    );
}

export default httpRequest
