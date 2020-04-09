import { h, Component } from "preact";
import "./style.scss";

export default class ContentChooser extends Component {
    constructor(props){
        super(props);
        this.state = {
            searchValue: '',
        };
    }

    handleSearchChange = (e) => {
        this.setState({searchValue: e.target.value});
    }

    handleSearch = () => {
        fetch(`/wp-json/wp/v2/pages?search=${this.state.searchValue}`)
        .then((res) => {
            return res.json();
        })
        .then((data) => {
            this.props.callback(data);
        })
    }
    
    render(){
        return (
            <div>
                <h3>Please search for a page to select options</h3>
                <input type="text" name="content" value={this.state.searchValue} onChange={this.handleSearchChange} />
                <button onClick={this.handleSearch}>Search</button>
            </div>
        )
    }
}