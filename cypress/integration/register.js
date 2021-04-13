describe('Register test', () => {
    beforeEach(() => {
        cy.viewport(1280, 720);
    });
    it('Register', () => {
        cy.visit("/register");
        cy.get('h1').should('contain', 'Register');
        cy.get('[data-test=email]').type("test@mail.ru");
        cy.get('[data-test=password]').type("12345678");
        cy.get('[data-cy=register]').click();
        cy.url().should('eq', Cypress.config().baseUrl);
        cy.get('h1').should('contain', 'Hello');
    })
})