import React from 'react'
import PropTypes from 'prop-types'

const Paginator = (props) => {
    const renderPageNumberButtons = () => {
        const first = Math.max(1, props.paginated_list.current_page - 4)
        const last = Math.min(props.paginated_list.last_page, props.paginated_list.current_page + 4)
        const list = []

        for (let i = first; i <= last; i++) {
            list.push(i)
        }

        return list.map(item => (
                <PaginatorButton onClick={() => props.onChangePage(item)}
                                 key={item}
                                 disabled={item === props.paginated_list.current_page}>
                    {item}
                </PaginatorButton>
            )
        )
    }

    return (
        <nav aria-label="Page navigation example">
            <ul className="pagination justify-content-center">
                <PaginatorButton onClick={() => props.onChangePage(1)}
                                 disabled={props.paginated_list.current_page === 1}>
                    &laquo;
                </PaginatorButton>
                {renderPageNumberButtons()}
                <PaginatorButton onClick={() => props.onChangePage(props.paginated_list.last_page)}
                                 disabled={props.paginated_list.current_page === props.paginated_list.last_page}>
                    &raquo;
                </PaginatorButton>

            </ul>
        </nav>
    )

}

Paginator.propTypes = {
    paginated_list: PropTypes.object.isRequired,
    onChangePage: PropTypes.func.isRequired
}

const PaginatorButton = (props) => {
    const onClick = e => {
        e.preventDefault()

        props.onClick()
    }

    if (props.disabled) {
        return (
            <li className="page-item disabled">
                <a className="page-link"
                   href="#"
                   tabIndex="-1"
                   aria-disabled="true"
                   onClick={e => e.preventDefault()}>
                    {props.children}
                </a>
            </li>
        )
    } else {
        return (
            <li className="page-item">
                <a className="page-link" href="#" onClick={onClick}>
                    {props.children}
                </a>
            </li>
        )
    }
}

PaginatorButton.propTypes = {
    disabled: PropTypes.bool,
    onClick: PropTypes.func.isRequired
}

PaginatorButton.defaultProps = {
    disabled: false
}

export default Paginator
