import { h, Component } from "preact";
import "./style.scss";

export default class PageList extends Component {
    constructor(props){
        super(props);
    }
    render(){
        const pageItems = this.props.data.map((page) => {
            console.log(page);
            return (
                <div>
                    <p>{page.title.rendered}</p>
                </div>
            );
        })
        return (
            <div>
                {pageItems}
            </div>
        )
    }

}