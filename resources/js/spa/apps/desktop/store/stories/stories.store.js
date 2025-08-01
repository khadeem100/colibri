import { defineStore } from 'pinia';
import { colibriAPI } from '@/kernel/services/api-client/native/index.js';

const useStoriesStore = defineStore('stories_store', {
    state: function() {
		return {
			storiesFeed: [],
            stories: [] 
		}
	},
    actions: {
        prependFeedItem: function(storyData) {
            const storyIndex = this.storiesFeed.findIndex((storyItem) => {
                return storyItem.story_uuid === storyData.story_uuid;
            });

            if(storyIndex !== -1) {
                this.storiesFeed.splice(storyIndex, 1);
            }

            this.storiesFeed.unshift(storyData);
        },
        fetchStoriesFeed: async function() {
            const state = this;

            await colibriAPI().stories().getFrom('feed').then((response) => {
                state.storiesFeed = response.data.data;
            }).catch((error) => {
                if(error.response) {
                    throw new Error(error.response.data.message);
                }
            });
        },
        fetchStory: async function(storyUUID) {
            const state = this;

            await colibriAPI().stories().getFrom(`stories/${storyUUID}`).then((response) => {
                state.stories = response.data.data;
            }).catch((error) => {
                if(error.response) {
                    throw new Error(error.response.data.message);
                }
            });
        },
        deleteStory: async function(storyUUID, frameId) {
            await colibriAPI().stories().with({
                frame_id: frameId
            }).delete('delete').then((response) => {
                const storyData = this.stories.find((storyItem) => {
                    return storyItem.story_uuid === storyUUID;
                });

                const frameIndex = storyData.relations.frames.findIndex((frameItem) => {
                    return frameItem.id === frameId;
                });

                storyData.relations.frames.splice(frameIndex, 1);

                this.stories = this.stories.filter((storyItem) => {
                    return storyItem.relations.frames.length > 0;
                });

                // Remove deleted story from storiesFeed if present
                this.storiesFeed = this.storiesFeed.filter((feedItem) => {
                    return this.stories.some((storyItem) => {
                        return storyItem.story_uuid === feedItem.story_uuid;
                    });
                });
            }).catch((error) => {
                if(error.response) {
                    throw new Error(error.response.data.message);
                }
            });
        },
        fetchAndReturnStoryViews: async function(frameId) {
            const state = this;

            return await colibriAPI().stories().getFrom(`views/${frameId}`).then((response) => {
                return response.data.data;
            }).catch((error) => {
                if(error.response) {
                    throw new Error(error.response.data.message);
                }
            });
        },
        recordStoryView: async function(storyUUID, frameId) {
            const frameData = this.stories.find((storyItem) => {
                return storyItem.story_uuid === storyUUID;
            }).relations.frames.find((frameItem) => {
                return frameItem.id === frameId;
            });

            frameData.activity.is_seen = true;
            
            await colibriAPI().stories().with({
                frame_id: frameId
            }).sendTo('views/record').catch((error) => {
                if(error.response) {
                    throw new Error(error.response.data.message);
                }
            });
        }
    }
});

export { useStoriesStore };