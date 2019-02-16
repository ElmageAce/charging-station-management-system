import React from 'react'
import PropTypes from 'prop-types'
import Row from "./Row";
import AddNewCompanyRow from "./AddNewCompanyRow";

const ListCard = (props) => {
    return (
        <div className="card">
            {props.title && <div className="card-header">{props.title}</div>}

            <div className="card-body">
                <ul className="list-group">
                    {props.hasAddRow && <AddNewCompanyRow submit={props.onAdd}/>}
                    {props.paginated_list.data.map(
                        company => (
                            <Row key={company.id}
                                 company={company}/>
                        )
                    )}
                </ul>
            </div>
        </div>
    )
}

ListCard.propTypes = {
    paginated_list: PropTypes.object.isRequired,
    hasAddRow: PropTypes.bool,
    onAdd: PropTypes.func,
    title: PropTypes.string
}

ListCard.defaultProps = {
    title: null,
    hasAddRow: false,
    onAdd: () => {}
}

export default ListCard
