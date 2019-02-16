import React, {useState} from 'react'
import PropTypes from 'prop-types'

const AddNewCompanyRow = (props) => {
    // Declare a new state variable, which we'll call "count"
    const [companyName, setCompanyName] = useState('')
    const [hasError, setHasError] = useState(false)

    const handleSubmit = (e) => {
        e.preventDefault()

        if (companyName.trim()) {
            props.submit(companyName)

            setCompanyName('')
        } else {
            setHasError('true')
        }
    }

    const onChangeInput = event => {
        setCompanyName(event.target.value)
        setHasError(false)
    }

    return (
        <li className="list-group-item d-flex justify-content-between align-items-center list-group-item-action">
            <form onSubmit={handleSubmit}>
                <input className="form-control" value={companyName} onChange={onChangeInput}/>
                {hasError && <small className="text-danger">Please enter correct company name!</small>}
            </form>
            <button className="btn btn-success btn-sm" onClick={handleSubmit}>
                <i className="fas fa-plus"/>
            </button>
        </li>
    )

}

AddNewCompanyRow.propTypes = {
    submit: PropTypes.func.isRequired
}

export default AddNewCompanyRow
