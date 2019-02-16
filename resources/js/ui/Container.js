import React from 'react'

const Container = (props) => {
    console.log(props)
    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col">
                    {props.children}
                </div>
            </div>
        </div>
    )
}

export default Container
