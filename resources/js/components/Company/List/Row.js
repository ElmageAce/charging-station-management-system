import React, {useState} from 'react'
import PropTypes from 'prop-types'
import {connect} from 'react-redux'
import {sendCompanyUpdateRequest} from "../../../store/company/update/actions";

const Row = (props) => {
    // Declare a new state variable, which we'll call "count"
    const [isEditMode, setIsEditMode] = useState(false);
    const [companyName, setCompanyName] = useState(props.company.name);

    const toggleIsEditMode = (e) => {
        e.stopPropagation();
        setIsEditMode(!isEditMode)
    }

    const handleSubmit = (e) => {
        e.preventDefault()

        props.dispatch(sendCompanyUpdateRequest(props.company, {name: companyName}))

        toggleIsEditMode(e)
    }

    if (isEditMode) {
        return (
            <li className="list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                <form onSubmit={handleSubmit}>
                    <input className="form-control" value={companyName} onChange={e => setCompanyName(e.target.value)}/>
                </form>
                <button className="btn btn-success btn-sm" onClick={handleSubmit}>
                    <i className="fas fa-check"/>
                </button>
            </li>
        )
    } else {
        return (
            <li className="list-group-item d-flex justify-content-between align-items-center list-group-item-action"
                onClick={() => _history.push('/company/' + props.company.id)}>
                {companyName}
                <button className="btn btn-primary btn-sm" onClick={toggleIsEditMode}>
                    <i className="fas fa-pencil-alt"/>
                </button>
            </li>
        )
    }
}

Row.propTypes = {
    company: PropTypes.object.isRequired
}

export default connect()(Row)
