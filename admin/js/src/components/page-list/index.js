import { h, Component } from "preact";
import PageItem from '../page-item';
import "./style.scss";

export default class PageList extends Component {
    constructor(props){
        super(props);
        this.state = {
            selectedPage: null,
        }
    }

    render(){
        return (
            <div>
                {this.props.data.map((page, i) =>
                <div>
                    <PageItem data={page} key={i} />
                </div>
                )}
            </div>
        )
    }

}