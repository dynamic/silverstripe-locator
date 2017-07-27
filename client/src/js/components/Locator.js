import React from 'react';

import Search from './SearchBar';
import Location from './Location';

class Locator extends React.Component {

    render() {
        console.log(this.props);
        return (
            <div>
                <Search/>
                <Location/>
            </div>
        );
    }

}

export default Locator;