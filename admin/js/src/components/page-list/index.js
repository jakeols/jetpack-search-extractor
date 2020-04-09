import { h, Component } from "preact";
import EditOptions from '../edit-options';
import "./style.scss";

export default class PageList extends Component {
    constructor(props){
        super(props);
        this.state = {
            selectedPage: null,
        }
    }

    render(){
        const pageItems = this.props.data.map((page) => {
            return (
                <div className="page-item">
                    <p>{page.title.rendered}</p>
                    <button onClick={() => this.setState({selectedPage: page})}>Edit Page</button>
                </div>
            );
        })
        return (
            <div>
                {pageItems}
                <EditOptions page={this.state.selectedPage} />
            </div>
        )
    }

}