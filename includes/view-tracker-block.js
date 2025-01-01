const { registerBlockType } = wp.blocks;
const { TextControl } = wp.components;

registerBlockType('view-tracker/block', {
    title: 'View Tracker',
    icon: 'chart-bar',
    category: 'widgets',
    attributes: {
        postId: {
            type: 'number',
            default: 0
        }
    },
    edit: (props) => {
        return (
            <div>
                <TextControl
                    label="Post ID"
                    value={props.attributes.postId}
                    onChange={(value) => props.setAttributes({ postId: parseInt(value) })}
                />
            </div>
        );
    },
    save: () => {
        return null; // Server-side rendering
    }
});
