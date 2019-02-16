import React from 'react'
import PropTypes from 'prop-types'
import Row from "./Row";
import AddNewStationRow from "./AddNewStationRow";

const ListCard = (props) => {
    return (
        <div className="card">
            {props.title && <div className="card-header">{props.title}</div>}

            <div className="card-body">
                <ul className="list-group">
                    {props.hasAddRow && <AddNewStationRow submit={props.onAdd}/>}
                    {props.paginated_list.data.map(
                        station => (
                            <Row key={station.id}
                                 station={station}/>
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
