describe('Login test', () => {
    it('Does not do much!', () => {
        cy.visit("/login");
        cy.url().should('contain', '/login');
        cy.get('[data-test=email]').type("admin@email.com").should('have.value', "admin@email.com");
        cy.get('[data-test=password]').type("admin123").should('have.value', "admin123");
        cy.get('[data-cy=login]').click();
        cy.url().should('eq', Cypress.config().baseUrl);
        cy.get('h1').should('contain', 'Hello');
    })
})
