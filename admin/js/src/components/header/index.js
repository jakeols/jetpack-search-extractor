import { h, Component } from "preact";
import "./style.scss";

export default class Header extends Component {
    
    render(){
        return (
            <div>
                <h1>Jetpack Search Extractor</h1>
                <p>Add custom post meta to your Jetpack Search Index</p>
            </div>
        )
    }
}