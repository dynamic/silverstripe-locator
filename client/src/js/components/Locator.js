import React from 'react';

import Search from './SearchBar';
import Map from './Map';

class Locator extends React.Component {

    render() {
        console.log(this.props);
        return (
            <div>
                <Search/>
                <Map/>
            </div>
        );
    }
}

export default Locator;