import React from 'react';

class Location extends React.Component {

    render() {
        const loc = this.props;
        return (
            <li data-markerid="0">
                <div className="list-label">1</div>
                <div className="list-details">
                    <div className="list-content">
                        <div className="loc-name">Location Name</div>
                        <div className="loc-addr">Address</div>

                        <div className="loc-addr3">City, State Zip</div>


                        <div className="loc-dist">
                            Distance&nbsp;|&nbsp;
                            <a href="#" target="_blank">Link</a>
                        </div>
                    </div>
                </div>
            </li>
        );
    }
}

export default Location;