import { defineStore } from 'pinia';
import axios from 'axios';

export const useClientStore = defineStore('client', {
    state: () => ({
        clients: [],
        pagination: {},
        loading: false,
        filters: {
            search: '',
            is_active: null,
            sort_by: 'created_at',
            sort_direction: 'desc',
            per_page: 20
        }
    }),

    actions: {
        async fetchClients() {
            this.loading = true;
            try {
                const response = await axios.get('/api/clients', {
                    params: this.filters
                });
                this.clients = response.data.data;
                this.pagination = {
                    current_page: response.data.current_page,
                    last_page: response.data.last_page,
                    per_page: response.data.per_page,
                    total: response.data.total
                };
            } catch (error) {
                console.error('Erro ao buscar clientes:', error);
            } finally {
                this.loading = false;
            }
        },

        async createClient(clientData) {
            try {
                const response = await axios.post('/api/clients/register', clientData);
                return response.data;
            } catch (error) {
                throw error;
            }
        },

        async updateClient(id, clientData) {
            try {
                const response = await axios.put(`/api/clients/${id}`, clientData);
                await this.fetchClients();
                return response.data;
            } catch (error) {
                throw error;
            }
        },

        async deleteClient(id) {
            try {
                await axios.delete(`/api/clients/${id}`);
                await this.fetchClients();
            } catch (error) {
                throw error;
            }
        },

        async bulkDeleteClients(ids) {
            try {
                await axios.delete('/api/clients/bulk-delete', { data: { ids } });
                await this.fetchClients();
            } catch (error) {
                throw error;
            }
        },

        async toggleClientStatus(id) {
            try {
                await axios.patch(`/api/clients/${id}/toggle-status`);
                await this.fetchClients();
            } catch (error) {
                throw error;
            }
        },

        setFilter(key, value) {
            this.filters[key] = value;
        },

        setPerPage(perPage) {
            this.filters.per_page = perPage;
        }
    }
});
